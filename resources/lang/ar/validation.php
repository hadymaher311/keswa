<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute يجب أن يكون مقبولا.',
    'active_url' => ':attribute ليس عنوانا صالحا.',
    'after' => ':attribute يجب ان يكون تاريخا بعد :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخا بعد أو يساوي :date.',
    'alpha' => ':attribute يجب أن يحتوي علي حروف.',
    'alpha_dash' => ':attribute يجب أن يحتوي علي حروف وأرقام شرطات وشرطات سفلية.',
    'alpha_num' => ':attribute يجب أن يحتوي علي حروف وأرقام.',
    'array' => ':attribute يجب أن يكون مجموعة.',
    'before' => ':attribute يجب أن يكون تاريخا قبل :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا قبل أو يساوي :date.',
    'between' => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلو بايت.',
        'string' => ':attribute يجب أن يكون بين :min و :max حرف.',
        'array' => ':attribute must have between :min و :max عنصر.',
    ],
    'boolean' => ':attribute يجب أن يكون صحيحا أو خاطئا.',
    'confirmed' => ':attribute تأكيد غير متطابق.',
    'date' => ':attribute ليس تاريخا صحيحا.',
    'date_equals' => ':attribute يجب ان يكون تاريخا يساوي :date.',
    'date_format' => ':attribute يجب أن يطابق :format.',
    'different' => ':attribute و :other يجب أن يكونوا مختلفين.',
    'digits' => ':attribute يجب ان يكون :digits رقم.',
    'digits_between' => ':attribute يجب أن يكون بين :min و :max رقم.',
    'dimensions' => ':attribute له أبعاد صورة غير صالحة.',
    'distinct' => ':attribute له قيمة مكررة.',
    'email' => ':attribute يجب أن يكون بريد الكتروني صحيح.',
    'ends_with' => ':attribute يجب أن ينتهي بالقيمة التالية: :values',
    'exists' => ':attribute المختار ليس صحيحا.',
    'file' => ':attribute يجب أن يكون ملفا.',
    'filled' => ':attribute يجب أن يحتوي علي قيمة.',
    'gt' => [
        'numeric' => ':attribute يجب أن تكون أكبر من :value.',
        'file' => ':attribute يجب أن تكون أكبر من :value كيلو بايت.',
        'string' => ':attribute يجب أن تكون أكبر من :value حرف.',
        'array' => ':attribute يجب أن يحتوي علي اكثر من :value عنصر.',
    ],
    'gte' => [
        'numeric' => ':attribute يجب أن تكون أكبر من أو يساوي :value.',
        'file' => ':attribute يجب أن تكون أكبر من أو يساوي :value كيلو بايت.',
        'string' => ':attribute يجب أن تكون أكبر من أو يساوي :value حرف.',
        'array' => ':attribute يجب أن يحتوي علي :value عنصر أو أكثر.',
    ],
    'image' => ':attribute يجب أن يكون صورة.',
    'in' => ':attribute المختار ليس صحيحا.',
    'in_array' => ':attribute ليس موجودا في :other.',
    'integer' => ':attribute يجب أن يكون رقما صحيحا.',
    'ip' => ':attribute يجب أن يكون عنوان IP صالحًا.',
    'ipv4' => ':attribute يجب أن يكون عنوان IPv4 صالحًا.',
    'ipv6' => ':attribute يجب أن يكون عنوان IPv4 صالحًا.',
    'json' => ':attribute يجب أن تكون سلسلة JSON صالحة.',
    'lt' => [
        'numeric' => ':attribute يجب أن يكون أقل من :value.',
        'file' => ':attribute يجب أن يكون أقل من :value كيلو بايت.',
        'string' => ':attribute يجب أن يكون أقل من :value حرف.',
        'array' => ':attribute يجب أن يكون أقل من :value عنصر.',
    ],
    'lte' => [
        'numeric' => ':attribute يجب أن يكون أقل من أو يساوي :value.',
        'file' => ':attribute يجب أن يكون أقل من أو يساوي :value كيلو بايت.',
        'string' => ':attribute يجب أن يكون أقل من أو يساوي :value حرف.',
        'array' => ':attribute يجب ألا يكون أكثر من :value عنصر.',
    ],
    'max' => [
        'numeric' => ':attribute قد لا يكون أكبر من :max.',
        'file' => ':attribute قد لا يكون أكبر من :max كيلو بايت.',
        'string' => ':attribute قد لا يكون أكبر من :max حرف.',
        'array' => ':attribute قد لا يكون أكثر من :max عنصر.',
    ],
    'mimes' => ':attribute يجب أن يكون ملف من النوع: :values.',
    'mimetypes' => ':attribute يجب أن يكون ملف من النوع: :values.',
    'min' => [
        'numeric' => ':attribute يجب أن يكون علي الأقل :min.',
        'file' => ':attribute يجب أن يكون علي الأقل :min كيلو بايت.',
        'string' => ':attribute يجب أن يكون علي الأقل :min حرف.',
        'array' => ':attribute يجب أن يحتوي علي الأقل :min عنصر.',
    ],
    'not_in' => ':attribute المختار ليس صحيحا.',
    'not_regex' => ':attribute بنية ليس صحيحا.',
    'numeric' => ':attribute يجب ان يكون رقما.',
    'present' => ':attribute يجب أن يكون حاضرا.',
    'regex' => ':attribute بنية ليس صحيحا.',
    'required' => 'الحقل :attribute مطلوب.',
    'required_if' => 'الحقل :attribute مطلوب عندما :other يكون :value.',
    'required_unless' => 'الحقل :attribute مطلوب unless :other يكون بين :values.',
    'required_with' => 'الحقل :attribute مطلوب عندما :values يكون موجودا.',
    'required_with_all' => 'الحقل :attribute مطلوب عندما :values يكونون موجودين.',
    'required_without' => 'الحقل :attribute مطلوب عندما :values يكونون غير موجودين.',
    'required_without_all' => 'الحقل :attribute مطلوب عندما none of :values يكونون موجودين.',
    'same' => ':attribute و :other يجب أن يتطابقا.',
    'size' => [
        'numeric' => ':attribute يجب ان يكون :size.',
        'file' => ':attribute يجب ان يكون :size كيلو بايت.',
        'string' => ':attribute يجب ان يكون :size حرف.',
        'array' => ':attribute يجب أن يحتوي :size عنصر.',
    ],
    'starts_with' => ':attribute يجب أن تبدأ بأحد الإجراءات التالية: :values',
    'string' => ':attribute يجب ان يكون كلمات.',
    'timezone' => ':attribute يجب ان يكون منطقة صحيحة.',
    'unique' => ':attribute تم استخدامه بالفعل.',
    'uploaded' => ':attribute فشل الرقغ.',
    'url' => ':attribute بنية ليس صحيحا.',
    'uuid' => ':attribute يجب ان يكون UUID صحيحا.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الكتروني',
        'password' => 'الرقم السري',
        'image' => 'الصورة',
    ],

];
