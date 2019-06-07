<?php
// kleeja plugin
// developer: kleeja team


// prevent illegal run
if (! defined('IN_PLUGINS_SYSTEM'))
{
    exit();
}


// plugin basic information
$kleeja_plugin['kj_recaptcha']['information'] = [
    // the casucal name of this plugin, anything can a human being understands
    'plugin_title' => [
        'en' => 'KJ reCaptcha',
        'ar' => 'كليجا ريكابتشا'
    ],
    // who wrote this plugin?
    'plugin_developer' => 'kleeja.com',
    // this plugin version
    'plugin_version' => '1.4',
    // explain what is this plugin, why should i use it?
    'plugin_description' => [
        'en' => 'Add reCaptcha to Kleeja',
        'ar' => 'إضافة ريكابتشا لكليجا'
    ],
    //settings page, if there is one (what after ? like cp=j_plugins)
    'settings_page' => 'cp=options&smt=kj_recaptcha',
    // min version of kleeja that's required to run this plugin
    'plugin_kleeja_version_min' => '2.0',
    // max version of kleeja that support this plugin, use 0 for unlimited
    'plugin_kleeja_version_max' => '3.9',
    // should this plugin run before others?, 0 is normal, and higher number has high priority
    'plugin_priority' => 0
];

//after installation message, you can remove it, it's not requiered
$kleeja_plugin['kj_recaptcha']['first_run']['ar'] = "
شكراً لاستخدامك إضافة الريكابتشا لكليجا.
<br>
للحصول على مفتاح وكود ريكابتشا السري سجل في موقعهم:
<a href='https://www.google.com/recaptcha'>google.com/reCaptcha</a>.
<br>
ثم أضفها في إعدادات -> خيارات الريكابتشا
";

$kleeja_plugin['kj_recaptcha']['first_run']['en'] = "
Thank you for using our plugin.
<br>
to get the reCaptcha sitekey and secret code, visit:
<a href='https://www.google.com/recaptcha'>google.com/reCaptcha</a>.
<br>
then configure this plugin from: settings -> reCaptcha settings
";

// plugin installation function
$kleeja_plugin['kj_recaptcha']['install'] = function ($plg_id) {
    //new options
    $options = [
        'kj_recaptcha_sitekey' =>
        [
            'value'  => '',
            'html'   => configField('kj_recaptcha_sitekey'),
            'plg_id' => $plg_id,
            'type'   => 'kj_recaptcha'
        ],
        'kj_recaptcha_secret' =>
        [
            'value'  => '',
            'html'   => configField('kj_recaptcha_secret'),
            'plg_id' => $plg_id,
            'type'   => 'kj_recaptcha'
        ],
        'kj_recaptcha_type' => [
            'value'  => '0',
            'html'   => configField('kj_recaptcha_type', 'select', [
                '{olang.KJ_RECAPTCHA_DISABLED}'  => 0,
                '{olang.KJ_RECAPTCHA_DEFAULT}'   => 1,
                '{olang.KJ_RECAPTCHA_INVISIBLE}' => 2,
                '{olang.KJ_RECAPTCHA_VERSION3}'  => 3
            ]),
            'plg_id' => $plg_id,
            'type'   => 'kj_recaptcha'
        ],
    ];


    add_config_r($options);


    //new language variables
    add_olang([
        'KJ_RECAPTCHA_SITEKEY'          => 'مفتاح الرياكبتشا | sitekey',
        'KJ_RECAPTCHA_SECRET'           => 'الكود السري للريكابتشا | secret',
        'KJ_RECAPTCHA_TYPE'             => 'نوع الريكابتشا',
        'KJ_RECAPTCHA_DEFAULT'          => 'نسخة 2 - ظاهرة',
        'KJ_RECAPTCHA_INVISIBLE'        => 'نسخة 2 - مخفية',
        'KJ_RECAPTCHA_VERSION3'         => 'نسخة 3',
        'KJ_RECAPTCHA_DISABLED'         => 'معطلة - بدون ريكابتشا',
        'CONFIG_KLJ_MENUS_KJ_RECAPTCHA' => 'خيارات ريكابتشا',
    ],
        'ar',
        $plg_id);

    add_olang([
        'KJ_RECAPTCHA_SITEKEY'          => 'reCaptcha sitekey',
        'KJ_RECAPTCHA_SECRET'           => 'reCaptcha secret',
        'KJ_RECAPTCHA_TYPE'             => 'ReCaptcha type',
        'KJ_RECAPTCHA_DEFAULT'          => 'version 2 - visible',
        'KJ_RECAPTCHA_INVISIBLE'        => 'version 2 - invisible',
        'KJ_RECAPTCHA_VERSION3'         => 'version 3',
        'KJ_RECAPTCHA_DISABLED'         => 'Disabled - No ReCaptcha',
        'CONFIG_KLJ_MENUS_KJ_RECAPTCHA' => 'reCaptcha Settings',
    ],
        'en',
        $plg_id);
};


//plugin update function, called if plugin is already installed but version is different than current
$kleeja_plugin['kj_recaptcha']['update'] = function ($old_version, $new_version) {
    $plg_id = Plugins::getInstance()->installed_plugin_info('kj_recaptcha');

    if (version_compare($old_version, '1.4', '<'))
    {
        delete_config('kj_recaptcha_invisible');
        delete_olang('KJ_RECAPTCHA_INVISIBLE');

        $options = [
            'kj_recaptcha_type' => [
                'value'  => '0',
                'html'   => configField('kj_recaptcha_type', 'select', [
                    '{olang.KJ_RECAPTCHA_DISABLED}'  => 0,
                    '{olang.KJ_RECAPTCHA_DEFAULT}'   => 1,
                    '{olang.KJ_RECAPTCHA_INVISIBLE}' => 2,
                    '{olang.KJ_RECAPTCHA_VERSION3}'  => 3
                ]),
                'plg_id' => $plg_id,
                'type'   => 'kj_recaptcha'
            ],
        ];


        add_config_r($options);

        //new language variables
        add_olang([
            'KJ_RECAPTCHA_TYPE'      => 'نوع الريكابتشا',
            'KJ_RECAPTCHA_DEFAULT'   => 'نسخة 2 - ظاهرة',
            'KJ_RECAPTCHA_INVISIBLE' => 'نسخة 2 - مخفية',
            'KJ_RECAPTCHA_VERSION3'  => 'نسخة 3',
            'KJ_RECAPTCHA_DISABLED'  => 'معطلة - بدون ريكابتشا',

        ],
            'ar',
            $plg_id);

        add_olang([
            'KJ_RECAPTCHA_TYPE'      => 'ReCaptcha type',
            'KJ_RECAPTCHA_DEFAULT'   => 'version 2 - visible',
            'KJ_RECAPTCHA_INVISIBLE' => 'version 2 - invisible',
            'KJ_RECAPTCHA_VERSION3'  => 'version 3',
            'KJ_RECAPTCHA_DISABLED'  => 'Disabled - No ReCaptcha',

        ],
            'en',
            $plg_id);
    }
};


// plugin uninstalling, function to be called at uninstalling
$kleeja_plugin['kj_recaptcha']['uninstall'] = function ($plg_id) {
    //delete options
    delete_config([
        'kj_recaptcha_sitekey',
        'kj_recaptcha_secret',
        'kj_recaptcha_type'
    ]);


    foreach (['ar', 'en'] as $language)
    {
        delete_olang(null, $language, $plg_id);
    }
};


// plugin functions
$kleeja_plugin['kj_recaptcha']['functions'] = [
    'Saaheader_links_func' => function ($args) {
        global $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        $extra = $args['extra'] . "\n" . getReCaptchaInputHeadHtml();
        return compact('extra');
    },

    'before_display_template_admin_page' => function ($args) {
        global $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        $extra_header_admin_login = $args['extra_header_admin_login'] . "\n" . getReCaptchaInputHeadHtml();
        $show_captcha = false;
        return compact('extra_header_admin_login', 'show_captcha');
    },

    'style_parse_func' => function($args) {
        global $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }


        if (in_array($args['template_name'], ['call', 'report', 'register', 'login']) && defined('reCaptcha_all'))
        {
            $html = preg_replace(
                '/(<IF\s{1,}NAME="config.enable_captcha==1">)/',
                getReCaptchaInputHtml() . '$1',
                $args['html']);

            return compact('html');
        }
        elseif ($args['template_name'] == 'index_body' && defined('reCaptcha_index'))
        {
            $html = preg_replace(
                    '/(<IF\s{1,}NAME="config.safe_code">)/',
                    getReCaptchaInputHtml() . '$1',
                    $args['html']);
            return compact('html');
        }
        elseif ($args['template_name'] == 'admin_login')
        {
            $html = preg_replace(
                    '/(<IF\s{1,}NAME="show_captcha">)/',
                    getReCaptchaInputHtml() . '$1',
                    $args['html']);

            unset($_SESSION['SHOW_CAPTCHA']);
            return compact('html');
        }
    },

    'admin_login_submit' => function($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! isReCaptchaValid())
        {
            $ERRORS = $args['ERRORS'];
            $ERRORS['recaptcha'] = $lang['WRONG_VERTY_CODE'];
            return compact('ERRORS');
        }
    },

    'end_common' => function($args) {
        global $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if ($config['safe_code'] == 1)
        {
            define('reCaptcha_index', true);
        }

        if ($config['enable_captcha'] == 1)
        {
            define('reCaptcha_all', true);
        }

        $config['enable_captcha'] = 0;
        $config['safe_code'] = 0;
    },

    'submit_report_go_page' => function ($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! isReCaptchaValid())
        {
            $ERRORS = $args['ERRORS'];
            $ERRORS['recaptcha'] = $lang['WRONG_VERTY_CODE'];
            return compact('ERRORS');
        }
    },

    'register_submit' => function ($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! isReCaptchaValid())
        {
            $ERRORS = $args['ERRORS'];
            $ERRORS['recaptcha'] = $lang['WRONG_VERTY_CODE'];
            return compact('ERRORS');
        }
    },


    'login_after_submit' => function ($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! isReCaptchaValid())
        {
            $ERRORS = $args['ERRORS'];
            $ERRORS['recaptcha'] = $lang['WRONG_VERTY_CODE'];
            return compact('ERRORS');
        }
    },

    'submit_call_go_page' => function($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! isReCaptchaValid())
        {
            $ERRORS = $args['ERRORS'];
            $ERRORS['recaptcha'] = $lang['WRONG_VERTY_CODE'];
            return compact('ERRORS');
        }
    },

    'defaultUploader_upload_1st' => function($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! defined('reCaptcha_index'))
        {
            return null;
        }

        $captcha_enabled = true;

        return compact('captcha_enabled');
    },


    'kleeja_check_captcha_func' => function($args) {
        global $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (defined('IN_REAL_INDEX'))
        {
            $return = isReCaptchaValid();
            return compact('return');
        }

        // if(defined('IN_ADMIN')) {
        $return = true;
        return compact('return');
    // }
    },

    'ftpUploader_upload_1st' => function($args) {
        global $lang, $config;

        if ($config['kj_recaptcha_type'] == 0)
        {
            return;
        }

        if (! defined('reCaptcha_index'))
        {
            return null;
        }

        $captcha_enabled = true;

        return compact('captcha_enabled');
    },

];




/**
 * special functions
 */

if (! function_exists('getReCaptchaInputHtml'))
{
    function getReCaptchaInputHtml()
    {
        global $config;

        if ($config['kj_recaptcha_type'] == 2 || $config['kj_recaptcha_type'] == 3)
        {
            return '<div id="aarecaptcha" data-size="invisible" style="display:none;margin: 10px 0; text-align: center; max-width: 255px;"></div>';;
        }
        elseif ($config['kj_recaptcha_type'] == 1)
        {
            return '<div class="g-recaptcha" data-sitekey="' . $config['kj_recaptcha_sitekey'] . '"  style="margin: 10px 0; text-align: center; max-width: 255px;"></div>';
        }
    }
}

if (! function_exists('getReCaptchaInputHeadHtml'))
{
    function getReCaptchaInputHeadHtml()
    {
        global $config;

        if ($config['kj_recaptcha_type'] == 2 || $config['kj_recaptcha_type'] == 3)
        {
            return '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=' . $config['language'] . '"></script>' .
               '<script>
                var disableSubmit = function(state){
                    var children = document.getElementsByTagName("form").childNodes;
                    var parent = null;
                    for(child in children){
                         if (children.hasOwnProperty(child)) {
                                if(child.getElementById("aarecaptcha") !== null){
                                    parent = child;
                                }
                            }
                    }

                    if(parent === null){
                        return;
                    }
                    parent.querySelectorAll("input[type=submit]").disabled = state;
                };
               var onloadCallback = function(){
                   disableSubmit(true);
                    grecaptcha.render("aarecaptcha", {
                        "sitekey" : "' . $config['kj_recaptcha_sitekey'] . '",
                        "badge" : "inline",
                        "size" : "invisible",
                        "callback" : function(token){
                              disableSubmit(false);
                           }
                      });
                     grecaptcha.execute();
               };
                 </script>';
        }
        elseif ($config['kj_recaptcha_type'] == 1)
        {
            return '<script src="https://www.google.com/recaptcha/api.js?hl=' . $config['language'] . '"></script>';
        }
    }
}

if (! function_exists('isReCaptchaValid'))
{
    function isReCaptchaValid()
    {
        global $config;

        if (empty($config['kj_recaptcha_sitekey']) || empty($config['kj_recaptcha_secret']))
        {
            return true;
        }

        if (! ip('g-recaptcha-response') || empty(p('g-recaptcha-response')))
        {
            return false;
        }

        try
        {
            $data = [
                'secret'   => $config['kj_recaptcha_secret'],
                'response' => p('g-recaptcha-response'),
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];


            $url = 'https://www.google.com/recaptcha/api/siteverify?' . http_build_query($data);

            $result = FetchFile::make($url)->get();


            if (empty($result) || is_null($result))
            {
                return false;
            }

            return (bool) json_decode($result)->success;
        }
        catch (Exception $e)
        {
            return null;
        }
    }
}
