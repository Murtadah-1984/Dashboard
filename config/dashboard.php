<?php

return [

    "company_name"=>"Arajeez",
    "company_email"=>"info@arajeez.com",
    "company_fullname"=>"Arajeez Company LLC",
    "company_banner"=>"images/AdminLTELogo.png",
    "company_logo"=>"images/AdminLTELogo.png",
    "company_url"=>"https://www.arajeez.com",
    "time_zone"=>"Asia/Baghdad",
    "company_sologon"=>"(إِنَّ اللَّـهَ هُوَ الرَّزَّاقُ ذُو الْقُوَّةِ الْمَتِينُ)",

    /*
     * The class name of the status model that holds all statuses.
     *
     * The model must be or extend `Spatie\ModelStatus\Status`.
     */
    'status_model' => App\Models\Status::class,

    /*
     * The name of the column which holds the ID of the model related to the statuses.
     *
     * You can change this value if you have set a different name in the migration for the statuses table.
     */
    'model_primary_key_attribute' => 'model_id',

    'hiddenColumns'=>['id','created_at','created_by','updated_at','updated_by','deleted_at','deleted_by']

];