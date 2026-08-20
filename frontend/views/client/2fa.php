<?php
$title = 'TRANG CHỦ | ' . $VCD->site('title');
$body['header'] = '
';
$body['footer'] = '

';
require_once __DIR__ . '/../../../core/is_user.php';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/nav.php';
//CheckLogin();
?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-2 px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                                <div style="min-height: calc(100vh - 350px)">
                    <div wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;lLsZC4Af9VujphKPH4oO&quot;,&quot;name&quot;:&quot;page.warranty&quot;,&quot;path&quot;:&quot;warranty-policy&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;08c5742ba96f680554f684bf842fd5edf40013c3ac2746398fb331a03569ec8e&quot;}" wire:effects="[]" wire:id="lLsZC4Af9VujphKPH4oO" class="grid grid-cols-1 gap-x-5 xl:grid-cols-12">
    <div class="xl:col-span-12">
        <div class="card print:shadow-none print:border-none">
            <div class="card-body print:hidden">
                <div class="flex flex-col gap-5 md:items-center md:flex-row">
                    <div class="grow">
                        <h1 class="mb-1 text-2xl">Hướng dẫn login acc có 2FA Auth</h1>

                    </div>
                </div>
            </div>
            <div class="!pt-0 card-body">
                <?= base64_decode($VCD->site('2falog')) ?>     </div>
        </div><!--end card-->
    </div><!--end col-->
</div>
                </div>

<?php require_once __DIR__ . '/footer.php'; ?>