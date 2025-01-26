<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class EditorialTeam extends Model
{
    /**
     * اسم الجدول المرتبط بالنموذج
     */
    protected $table = 'editorial_team';

    /**
     * الخصائص التي يمكن تعيينها بشكل جماعي
     */
    protected $fillable = [
        'name',
        'position',
        'team_type',
        'image',
        'bio',
        'social_facebook',
        'social_twitter',
        'social_linkedin',
        'order_num',
        'status'
    ];

    /**
     * تحويل حقل الصورة إلى رابط كامل
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/' . $value) : null
        );
    }

    /**
     * تحويل نوع الفريق إلى نص مقروء
     */
    protected function teamTypeText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->team_type) {
                    'board_of_directors' => 'مجلس الإدارة',
                    'editorial_board' => 'هيئة التحرير',
                    default => $this->team_type
                };
            }
        );
    }

    /**
     * تحويل الحالة إلى نص مقروء
     */
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->status) {
                    'active' => 'نشط',
                    'inactive' => 'غير نشط',
                    default => $this->status
                };
            }
        );
    }

    /**
     * تحويل الحالة إلى لون
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->status) {
                    'active' => 'green',
                    'inactive' => 'red',
                    default => 'gray'
                };
            }
        );
    }

    /**
     * الحصول على الأعضاء النشطين فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * الحصول على أعضاء قسم معين
     */
    public function scopeByTeamType($query, string $type)
    {
        return $query->where('team_type', $type);
    }

    /**
     * الحصول على الأعضاء مرتبين حسب الترتيب
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_num');
    }

    /**
     * إعادة ترتيب الأعضاء بعد الحذف
     */
    public static function reorderAfterDelete(string $teamType)
    {
        $members = self::where('team_type', $teamType)
            ->orderBy('order_num')
            ->get();

        foreach ($members as $index => $member) {
            $member->update(['order_num' => $index + 1]);
        }
    }

    /**
     * التحقق من وجود روابط تواصل اجتماعي
     */
    public function hasSocialLinks(): bool
    {
        return !empty($this->social_facebook) || 
               !empty($this->social_twitter) || 
               !empty($this->social_linkedin);
    }

    /**
     * الحصول على روابط التواصل الاجتماعي كمصفوفة
     */
    public function getSocialLinks(): array
    {
        $links = [];
        
        if (!empty($this->social_facebook)) {
            $links['facebook'] = [
                'url' => $this->social_facebook,
                'icon' => 'fab fa-facebook',
                'name' => 'فيسبوك'
            ];
        }
        
        if (!empty($this->social_twitter)) {
            $links['twitter'] = [
                'url' => $this->social_twitter,
                'icon' => 'fab fa-twitter',
                'name' => 'تويتر'
            ];
        }
        
        if (!empty($this->social_linkedin)) {
            $links['linkedin'] = [
                'url' => $this->social_linkedin,
                'icon' => 'fab fa-linkedin',
                'name' => 'لينكد إن'
            ];
        }
        
        return $links;
    }
}
