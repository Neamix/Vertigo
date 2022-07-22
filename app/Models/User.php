<?php

namespace App\Models;

use App\Exports\UsersExport;
use App\Http\Helpers\Mailers;
use App\Http\Helpers\Tenent;
use App\Services\ImageService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Mailers,ImageService;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $root = 'storage/images/avatar';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function login($request)
    {
        $isValid = (new self)->isValid($request['input']['email'],$request['input']['password']);
        if ($isValid) {
            $user = User::where('email',$request['input']['email'])->first();
            $token = $user->createToken('Token Name')->accessToken;

            return [
                'access_token' => $token,
                'user' => $user
            ];
        }
    }

    public function isValid($email,$password) 
    {
        $checkCredintions = Auth::attempt(['email' => $email,'password' => $password]);
        return $checkCredintions;
    }

    public function addRole($role_id)
    {
        $this->role_id = $role_id;
        $this->save();
        return $this;
    }

    static function upsertInstance($request)
    {
       
        if ( $request['input']['id'] ) {
            $userOld = User::find($request['input']['id']);
        }

        $user =   User::updateOrCreate(
                    [
                        'id' => $request['input']['id'] ?? null
                    ],
                    [
                        'name'  => $request['input']['name'],
                        'email' => $request['input']['email'],
                        'company_id' => Auth::user()->company_id
                    ]);

        if ($userOld->email != $user->email) {
            DB::table('password_resets')->where('email',$userOld->email)->delete();
            $user->sendForgetEmail();
        }
        
        if( ! $request['input']['id'] ) {
            $user->sendForgetEmail();
        }

        return $user;
    }

    public function sendForgetEmail($verify = false)
    {
        $token = Str::random(32);
        $this->storeResetToken($token);
        $this->changePassword($token,$verify);
        return 'Forget message has been send successfully';
    }

    public function storeResetToken($token)
    {
        return DB::table('password_resets')->updateOrInsert(
        ['email' => $this->email],
        [
            'email' => $this->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function resetPassword($request)
    {
        $this->password = Hash::make($request['input']['password']);
        $this->save();
        
        DB::table('password_resets')->where([
            'token' => $request['input']['token'],
            'email' => $request['input']['email']
        ])->delete();

        User::where([
            'email' => $request['input']['email'],
            'email_verified_at' => null
        ])->update(['email_verified_at' => Carbon::now()]);

        return 'Your password has been changed successfully';
    }

    static function modifyUserAvatar($avatar)
    {
        $user = Auth::user();

        (new self)->deleteImageByName((new self)->root.'/small/'.$user->avatar);

        $avatar = (new self)->dimintions(['small' => '300x300'])
                  ->files($avatar)
                  ->fit()
                  ->store()
                  ->prefix('avatar_')
                  ->compile()[0];

        $user->avatar = $avatar;
        $user->save();
    
        return $user;
    }

    static function modifyUserCover($cover)
    {
        $user = Auth::user();

        (new self)->deleteImageByName((new self)->root.'/small/'.$user->cover);

        $cover = (new self)->dimintions(['small' => '1600x800'])
                  ->files($cover)
                  ->fit()
                  ->store()
                  ->prefix('cover_')
                  ->compile()[0];

        $user->cover = $cover;
        $user->save();
    
        return $user;
    }

    public function deleteInstance()
    {
        $this->delete();
        return $this;
    }

    public function toggleUserActivateInstance()
    {
        $this->active = !$this->active;
        $this->save();

        return $this;
    }

    static function exportUserExcel($extention)
    {
        abort_if(!in_array($extention,['xlsx','pdf','csv']),504,"unsupported formate");

        $name = md5(rand(10000000000,99999999999)).".$extention";

        if ( $extention == 'pdf' ) {
                Excel::store(new UsersExport,"files/$name",'local' ,\Maatwebsite\Excel\Excel::DOMPDF);
        } else {
                Excel::store(new UsersExport,"files/$name");
        }

        return $name;
    }

    static function hasPriviledge()
    {
        
    }

    //Accessors

    public function getAvatarPathAttribute()
    {
        return 'storage/images/'.$this->avatar;
    }

    //Scopes 

    public function scopeFilter($query,$search_array) 
    {
        if ( ! empty($search_array['input']['name']) ) {
            $query->where('name', 'LIKE', '%'. $search_array['input']['name'] .'%');
        }

        return $query;
    }

    // Relations

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
