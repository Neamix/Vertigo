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
        'role_id',
        'company_id'
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
        $user = User::where('email',$request['input']['email'])->first();
        $token = $user->createToken('Token Name')->accessToken;

        return [
            'access_token' => $token,
            'user' => $user
        ];
    }

    public function addRole($role_id)
    {
        $this->role_id = $role_id;
        $this->save();
        return $this;
    }

    static function upsertInstance($request)
    {
        $user = User::updateOrCreate(
                    [
                        'id' => $request['input']['id'] ?? null
                    ],
                    [
                        'name'  => $request['input']['name'],
                        'email' => $request['input']['email'],
                        'role_id' => $request['input']['role'],
                        'company_id' => Auth::user()->company_id ?? 1
                    ]
                );
        if ( isset($request['input']['id']) ) {
            $userOld = User::find($request['input']['id']);

            if ($userOld->email != $user->email) {
                DB::table('password_resets')->where('email',$userOld->email)->delete();
                $user->sendForgetEmail();
            }
        } 
        
        if( ! isset($request['input']['id']) ) {
            $user->sendForgetEmail();
        }

        return [
            'status' => 'Success'
        ];
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
        return [
            'status' => 'Success'
        ];
    }

    public function toggleUserActivateInstance()
    {
        $this->active = !$this->active;
        $this->save();

        return [
            'status' => 'Success'
        ];
    }

    static function exportUserFiles($args)
    {
        $extention = $args['type'];

        abort_if(!in_array($extention,['xlsx','pdf','csv']),504,"unsupported formate");

        $name = md5(rand(10000000000,99999999999)).".$extention";

        if ( $extention == 'pdf' ) {
                Excel::store(new UsersExport($args),"files/$name",'local' ,\Maatwebsite\Excel\Excel::DOMPDF);
        } else {
                Excel::store(new UsersExport($args),"files/$name");
        }

        return $name;
    }

    public function isPartner()
    {
        return ($this->role_id == PARTNER) ? true : false;
    }

    public function isSuperAdmin()
    {
        return ($this->role_id == SUPER_ADMIN) ? true : false;
    }

    public function hasPriviledge($priviledge)
    {
        $hasPriviledges = $this->role->priviledges->where('id',$priviledge)->count();

        $authorized = ( $hasPriviledges || Auth::user()->isPartner() || Auth::user()->isSuperAdmin() ) ? true : false;

        return $authorized;
    }

    //Accessors

    public function getAvatarPathAttribute()
    {
        return 'storage/images/'.$this->avatar;
    }

    //Scopes 

    public function scopeFilter($query,$search_array) 
    {
        if ( ! empty($search_array['name']) ) {
            $query->where('name', 'LIKE', '%'. $search_array['name'] .'%');
        }

        if ( ! empty($search_array['role']) && isset($search_array['role']) ) {
            $query->where('role_id',$search_array['role']);
        }

        $query->where('id','!=',Auth::user()->id);

        return $query;
    }

    // Relations

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function testMail()
    {
        self::testMail();
    }

}
