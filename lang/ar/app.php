<?php

return [
    'name' => 'نظام إدارة الدعوات',
    'description' => 'نظام شامل لإدارة الدعوات والضيوف والفعاليات',
    
    'navigation' => [
        'dashboard' => 'لوحة التحكم',
        'users' => 'المستخدمين',
        'roles' => 'الأدوار',
        'permissions' => 'الصلاحيات',
        'invitations' => 'الدعوات',
        'templates' => 'القوالب',
        'staff' => 'الموظفين',
        'guests' => 'الضيوف',
    ],
    
    'auth' => [
        'login' => 'تسجيل الدخول',
        'register' => 'التسجيل',
        'logout' => 'تسجيل الخروج',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'confirm_password' => 'تأكيد كلمة المرور',
        'forgot_password' => 'نسيت كلمة المرور؟',
        'reset_password' => 'إعادة تعيين كلمة المرور',
        'change_password' => 'تغيير كلمة المرور',
        'current_password' => 'كلمة المرور الحالية',
        'new_password' => 'كلمة المرور الجديدة',
        'remember_me' => 'تذكرني',
    ],
    
    'roles' => [
        'super_admin' => 'مدير عام',
        'admin' => 'مدير',
        'user' => 'مستخدم',
    ],
    
    'status' => [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'draft' => 'مسودة',
        'sent' => 'مرسل',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'invited' => 'مدعو',
        'confirmed' => 'مؤكد',
        'arrived' => 'وصل',
        'no_show' => 'لم يحضر',
        'on_leave' => 'في إجازة',
    ],
    
    'actions' => [
        'create' => 'إنشاء',
        'edit' => 'تعديل',
        'delete' => 'حذف',
        'view' => 'عرض',
        'save' => 'حفظ',
        'cancel' => 'إلغاء',
        'back' => 'رجوع',
        'send' => 'إرسال',
        'assign' => 'تعيين',
        'mark_arrived' => 'تحديد الوصول',
    ],
    
    'messages' => [
        'created' => 'تم إنشاء السجل بنجاح',
        'updated' => 'تم تحديث السجل بنجاح',
        'deleted' => 'تم حذف السجل بنجاح',
        'error' => 'حدث خطأ',
    ],

    'languages' => [
        'english' => 'US English',
        'arabic' => 'SA العربية',
    ],
];
