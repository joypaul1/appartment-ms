<?php

return [


    'accepted'             => 'The :attribute must be accepted.',
    'accepted_if'          => 'The :attribute must be accepted when :other is :value.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute must only contain letters.',
    'alpha_dash'           => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute must only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'array'   => 'The :attribute must have between :min and :max items.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute must be between :min and :max.',
        'string'  => 'The :attribute must be between :min and :max characters.',
    ],
    'boolean'              => ':অ্যাট্রিবিউট ক্ষেত্রটি সত্য বা মিথ্যা হতে হবে।',
    'confirmed'            => ':attribute নিশ্চিতকরণ মেলে না।',
    'current_password'     => 'পাসওয়ার্ডটি ভুল।',
    'date'                 => ':attribute একটি বৈধ তারিখ নয়।',
    'date_equals'          => ':attributeটি অবশ্যই :date-এর সমান একটি তারিখ হতে হবে।',
    'date_format'          => ':attribute ফরম্যাটের সাথে মেলে না :format।',
    'declined'             => ':অ্যাট্রিবিউট অবশ্যই প্রত্যাখ্যান করতে হবে।',
    'declined_if'          => ':অ্যাট্রিবিউটটি অবশ্যই প্রত্যাখ্যান করতে হবে যখন :other হয় :value।',
    'different'            => ':attribute এবং :other ভিন্ন হতে হবে।',
    'digits'               => ':attribute অবশ্যই :digits digits হতে হবে।',
    'digits_between'       => ':attribute অবশ্যই :min এবং :max সংখ্যার মধ্যে হতে হবে।',
    'dimensions'           => ':attribute-এর অবৈধ চিত্র মাত্রা রয়েছে।',
    'distinct'             => ':attribute ক্ষেত্রের একটি ডুপ্লিকেট মান আছে।',
    'doesnt_end_with'      => ':অ্যাট্রিবিউট নিচের একটির সাথে শেষ নাও হতে পারে: :values।',
    'doesnt_start_with'    => ':attribute নিম্নলিখিতগুলির একটি দিয়ে শুরু নাও হতে পারে: :values।',
    'email'                => ':attribute অবশ্যই একটি বৈধ ইমেইল ঠিকানা হতে হবে।',
    'ends_with'            => ':অ্যাট্রিবিউটটি অবশ্যই নিম্নলিখিতগুলির একটি দিয়ে শেষ হতে হবে: :values।',
    'enum'                 => 'নির্বাচিত :অ্যাট্রিবিউটটি অবৈধ।',
    'exists'               => 'নির্বাচিত :অ্যাট্রিবিউটটি অবৈধ।',
    'file'                 => ':অ্যাট্রিবিউটটি অবশ্যই একটি ফাইল হতে হবে।',
    'filled'               => ':attribute ক্ষেত্রের একটি মান থাকতে হবে।',
    'gt'                   => [
        'array'   => ':attribute-এ অবশ্যই :value আইটেমের চেয়ে বেশি থাকতে হবে।',
        'file'    => ':attributeটি অবশ্যই :value কিলোবাইটের থেকে বেশি হতে হবে।',
        'numeric' => ':attributeটি অবশ্যই :value এর থেকে বড় হতে হবে।',
        'string'  => ':attribute অবশ্যই :value অক্ষরের চেয়ে বড় হতে হবে।',
    ],
    'gte'                  => [
        'array'   => ':attribute-এর অবশ্যই :value আইটেম বা তার বেশি থাকতে হবে।',
        'file'    => ':attributeটি অবশ্যই :value কিলোবাইটের থেকে বড় বা সমান হতে হবে।',
        'numeric' => ':attribute অবশ্যই :value এর থেকে বড় বা সমান হতে হবে।',
        'string'  => ':attribute অবশ্যই :value অক্ষরের চেয়ে বড় বা সমান হতে হবে।',
    ],
    'image'                => ': বৈশিষ্ট্যটি অবশ্যই একটি চিত্র হতে হবে।',
    'in'                   => 'নির্বাচিত :অ্যাট্রিবিউটটি অবৈধ।',
    'in_array'             => ':attribute ক্ষেত্রটি :other-এ বিদ্যমান নেই।',
    'integer'              => ':বিষয়টি অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।',
    'ip'                   => ':attribute অবশ্যই একটি বৈধ IP ঠিকানা হতে হবে।',
    'ipv4'                 => ':attribute অবশ্যই একটি বৈধ IPv4 ঠিকানা হতে হবে।',
    'ipv6'                 => ':অ্যাট্রিবিউটটি অবশ্যই একটি বৈধ IPv6 ঠিকানা হতে হবে।',
    'json'                 => ':attribute অবশ্যই একটি বৈধ JSON স্ট্রিং হতে হবে।',
    'lt'                   => [
        'array'   => ':attribute-এ অবশ্যই :value আইটেম থেকে কম থাকতে হবে।',
        'file'    => ':attributeটি অবশ্যই :value kilobytes-এর চেয়ে কম হতে হবে।',
        'numeric' => ':attributeটি অবশ্যই :value-এর চেয়ে কম হতে হবে।',
        'string'  => ':attribute অবশ্যই :value অক্ষরের চেয়ে কম হতে হবে।',
    ],
    'lte'                  => [
        'array'   => ':attribute-এ অবশ্যই :value আইটেমের বেশি থাকা উচিত নয়।',
        'file'    => ':attributeটি অবশ্যই :value কিলোবাইটের থেকে কম বা সমান হতে হবে।',
        'numeric' => ':attribute অবশ্যই :value এর থেকে কম বা সমান হতে হবে।',
        'string'  => ':attribute অবশ্যই :value অক্ষরের চেয়ে কম বা সমান হতে হবে।',
    ],
    'mac_address'          => ':attribute অবশ্যই একটি বৈধ MAC ঠিকানা হতে হবে।',
    'max'                  => [
        'array'   => ':attribute-এ অবশ্যই :max এর বেশি আইটেম থাকবে না।',
        'file'    => ':attribute অবশ্যই :max kilobytes-এর থেকে বেশি হওয়া উচিত নয়।',
        'numeric' => ':অ্যাট্রিবিউটটি অবশ্যই :max এর থেকে বেশি হওয়া উচিত নয়।',
        'string'  => ':attribute অবশ্যই :max অক্ষরের চেয়ে বেশি হওয়া উচিত নয়।',
    ],
    'max_digits'           => ':অ্যাট্রিবিউটে অবশ্যই :max সংখ্যার বেশি হওয়া উচিত নয়।',
    'mimes'                => ':attribute অবশ্যই একটি ফাইল হতে হবে: :values।',
    'mimetypes'            => ':attribute অবশ্যই একটি ফাইল হতে হবে: :values।',
    'min'                  => [
        'array'   => ':attribute তে কমপক্ষে :min আইটেম থাকতে হবে।',
        'file'    => ':attribute অন্তত:মিন কিলোবাইট হতে হবে।',
        'numeric' => ':attribute অন্তত:min হতে হবে।',
        'string'  => ':attribute অন্তত:মিন অক্ষরের হতে হবে।',
    ],
    'min_digits'           => ':অ্যাট্রিবিউটে অন্তত:মিন সংখ্যা থাকতে হবে।',
    'multiple_of'          => ':attributeটি অবশ্যই :value-এর একাধিক হতে হবে।',
    'not_in'               => 'নির্বাচিত :অ্যাট্রিবিউটটি অবৈধ।',
    'not_regex'            => ':attribute বিন্যাসটি অবৈধ।',
    'numeric'              => ':বিষয়টি অবশ্যই একটি সংখ্যা হতে হবে।',
    'password'             => [
        'letter'        => ':অ্যাট্রিবিউটে অন্তত একটি অক্ষর থাকতে হবে।',
        'mixed'         => ':অ্যাট্রিবিউটে অন্তত একটি বড় হাতের এবং একটি ছোট হাতের অক্ষর থাকতে হবে।',
        'numbers'       => ':attribute তে অন্তত একটি সংখ্যা থাকতে হবে।',
        'symbols'       => ':attribute তে অন্তত একটি চিহ্ন থাকতে হবে।',
        'uncompromised' => 'প্রদত্ত :অ্যাট্রিবিউটটি একটি ডেটা ফাঁসের মধ্যে উপস্থিত হয়েছে। অনুগ্রহ করে একটি ভিন্ন চয়ন করুন: বৈশিষ্ট্য।',
    ],
    'present'              => ':attribute ক্ষেত্রটি অবশ্যই উপস্থিত থাকতে হবে।',
    'prohibited'           => ':attribute ক্ষেত্রটি নিষিদ্ধ।',
    'prohibited_if'        => ':attribute ক্ষেত্রটি নিষিদ্ধ যখন :other হয় :value।',
    'prohibited_unless'    => ':attribute ক্ষেত্রটি নিষিদ্ধ যদি না :other :values-এ না থাকে।',
    'prohibits'            => ':attribute ক্ষেত্রটি :অন্যকে উপস্থিত হতে নিষেধ করে।',
    'regex'                => ':attribute বিন্যাসটি অবৈধ।',
    'required'             => ':attribute ক্ষেত্রটি আবশ্যক।',
    'required_array_keys'  => ':attribute ফিল্ডে অবশ্যই :values ​​এর জন্য এন্ট্রি থাকতে হবে।',
    'required_if'          => ':অ্যাট্রিবিউট ক্ষেত্রটি প্রয়োজন হয় যখন :other হয় :value।',
    'required_unless'      => ':অ্যাট্রিবিউট ক্ষেত্রটি প্রয়োজন যদি না :অন্য :মানে থাকে।',
    'required_with'        => ':values ​​উপস্থিত থাকলে :attribute ফিল্ডের প্রয়োজন হয়।',
    'required_with_all'    => ':values ​​উপস্থিত থাকলে :attribute ফিল্ডের প্রয়োজন হয়।',
    'required_without'     => ':values ​​উপস্থিত না থাকলে :attribute ফিল্ডের প্রয়োজন হয়।',
    'required_without_all' => ':মানগুলির কোনোটিই উপস্থিত না থাকলে :attribute ক্ষেত্রটি প্রয়োজন হয়।',
    'same'                 => ':attribute এবং :other অবশ্যই মিলবে।',
    'size'                 => [
        'array'   => ':attribute-এ অবশ্যই :size আইটেম থাকতে হবে।',
        'file'    => ':attributeটি অবশ্যই :size kilobytes হতে হবে।',
        'numeric' => ':attribute অবশ্যই :size হতে হবে।',
        'string'  => ':attribute অবশ্যই :size অক্ষর হতে হবে।',
    ],
    'starts_with'          => ':অ্যাট্রিবিউটটি অবশ্যই নিম্নলিখিতগুলির একটি দিয়ে শুরু করতে হবে: :values।',
    'string'               => ':অ্যাট্রিবিউটটি অবশ্যই একটি স্ট্রিং হতে হবে।',
    'timezone'             => ':অ্যাট্রিবিউট অবশ্যই একটি বৈধ টাইমজোন হতে হবে।',
    'unique'               => ':অ্যাট্রিবিউটটি ইতিমধ্যেই নেওয়া হয়েছে।',
    'uploaded'             => ':attribute আপলোড করতে ব্যর্থ হয়েছে।',
    'url'                  => ':attribute অবশ্যই একটি বৈধ URL হতে হবে।',
    'uuid'                 => ':বিষয়টি অবশ্যই একটি বৈধ UUID হতে হবে।',

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

    'custom'               => [
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

    'attributes'           => [],

];
