<?php

namespace Laravin\Referral\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReferralLink extends Model
{
    protected $fillable = [
        'code',
    ];

    protected static function boot()
    {
        static::creating(function (ReferralLink $model) {
            $model->generateCode();
        });
    }

    private function generateCode()
    {
        $this->code = str()->random(25);
    }

    public static function getReferral($user, $program)
    {
        return static::firstOrCreate([
            'user_id' => $user->id,
            'referral_program_id' => $program->id,
        ]);
    }

    public function getLinkAttribute()
    {
        return url($this->program->uri).'?ref='.$this->code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(ReferralProgram::class, 'referral_program_id');
    }

    public function relationships()
    {
        return $this->hasMany(ReferralRelationship::class);
    }
}
