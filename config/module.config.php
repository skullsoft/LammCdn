<?php

return array(
    'view_helpers' => array(
        'factories' => array(
            'headLinkCdn' => 'LammCdn\View\Helper\Service\HeadLinkCdnFactory',
            'headScriptCdn' => 'LammCdn\View\Helper\Service\HeadScriptCdnFactory',
            'footerScriptCdn' => 'LammCdn\View\Helper\Service\FooterScriptCdnFactory',
            'linkCdn' => 'LammCdn\View\Helper\Service\LinkCdnFactory',
            'MiEchoFAC' => 'LammCdn\View\Helper\Service\MiEchoFactory',
            'linkElements' => 'LammCdn\View\Helper\Service\LinkElementsFactory',
        ),
        'aliases' => array(
            'MiEcho' => 'MiEchoFAC',
            'headLink' => 'headLinkCdn',
            'headScript' => 'headScriptCdn',
            'footerScript' => 'footerScriptCdn',
        ),
    ),
);
