<?php
$title = $VCD->site('title');
$body['header'] = '
';
$body['footer'] = '

';
require_once __DIR__ . '/../../../core/is_user.php';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/nav.php';
CheckLogin();
?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-2 px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                                <div style="min-height: calc(100vh - 350px)">
                    <div wire:snapshot="{&quot;data&quot;:{&quot;oldPassword&quot;:null,&quot;newPassword&quot;:null,&quot;confirmPassword&quot;:null},&quot;memo&quot;:{&quot;id&quot;:&quot;QYXaAwRzEUFsZUgtXECQ&quot;,&quot;name&quot;:&quot;auth.profile&quot;,&quot;path&quot;:&quot;auth\/profile&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;d7c3c99cd234860036c73633ac014fd429d6dc9a4f4ba14e45a6ab73c909ea28&quot;}" wire:effects="[]" wire:id="QYXaAwRzEUFsZUgtXECQ" class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow">
            <h5 class="text-16">Cài đặt tài khoản</h5>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-12 2xl:grid-cols-12">
                <div class="lg:col-span-2 2xl:col-span-1">
                    <div class="relative inline-block rounded-full shadow-md size-20 bg-slate-100 profile-user xl:size-28">
                        <img src="<?= $VCD->site('favicon') ?>" alt="" class="object-cover border-0 rounded-full img-thumbnail user-profile-image">
                        <div class="absolute bottom-0 flex items-center justify-center rounded-full size-8 ltr:right-0 rtl:left-0 profile-photo-edit">
                            <input id="profile-img-file-input" type="file" class="hidden profile-img-file-input">
                            <label for="profile-img-file-input" class="flex items-center justify-center bg-white rounded-full shadow-lg cursor-pointer size-8 dark:bg-zink-600 profile-photo-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="image-plus" class="lucide lucide-image-plus size-4 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-500"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path><line x1="16" x2="22" y1="5" y2="5"></line><line x1="19" x2="19" y1="2" y2="8"></line><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                            </label>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="lg:col-span-10 2xl:col-span-9">
                    <h5 class="mb-1"><?=$getUser['username'];?></h5>
                    <h5 class="mb-1">ID: <?=$getUser['id'];?></h5>

                </div>
            </div>
        </div>
        <div class="card-body !py-0">
            <ul class="flex flex-wrap w-full text-sm font-medium text-center nav-tabs">
                <li class="group active">
                    <a href="javascript:void(0);" data-tab-toggle="" data-target="changePasswordTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">Đổi mật khẩu</a>
                </li>

            </ul>
        </div>
    </div><!--end card-->

    <div class="tab-content">
        <div class="tab-pane active" id="changePasswordTabs">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4 text-15">Đổi mật khẩu</h6>
                    <form method="post" wire:submit="changePassword">
                        <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                               <input type="hidden" class="form-control" id="token" value="<?= $getUser['token'] ?>" readonly>     
                            <div class="xl:col-span-4">
                                <label for="inputValue" class="inline-block mb-2 text-base font-medium">Mật khẩu cũ
                                    *</label>
                                <div class="relative">
                                    <input type="password" wire:model="oldPassword" id="old_password"  name="old_password" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="oldpasswordInput">
                                    <button class="absolute top-2 ltr:right-4 rtl:left-4 " type="button">
                                        <i class="align-middle ri-eye-fill text-slate-500 dark:text-zink-200"></i>
                                    </button>
                                </div>
                            </div><!--end col-->
                            <div class="xl:col-span-4">
                                <label for="inputValue" class="inline-block mb-2 text-base font-medium">Mật khẩu mới
                                    *</label>
                                <div class="relative">
                                    <input type="password" wire:model="newPassword" id="new_password"  name="new_password"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="oldpasswordInput">
                                    <button class="absolute top-2 ltr:right-4 rtl:left-4 " type="button"><i class="align-middle ri-eye-fill text-slate-500 dark:text-zink-200"></i>
                                    </button>
                                </div>
                            </div><!--end col-->
                            <div class="xl:col-span-4">
                                <label for="inputValue" class="inline-block mb-2 text-base font-medium">Nhập lại mật khẩu
                                    *</label>
                                <div class="relative">
                                    <input type="password" id="confirm_new_password" name="confirm_new_password" wire:model="confirmPassword" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="oldpasswordInput">
                                    <button class="absolute top-2 ltr:right-4 rtl:left-4 " type="button"><i class="align-middle ri-eye-fill text-slate-500 dark:text-zink-200"></i>
                                    </button>
                                </div>
                            </div><!--end col-->
                            <div class="flex justify-end xl:col-span-6">
                                <button type="submit" id="changePass" wire:loading.class="opacity-50" class="text-white bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/10">
                                    Change Password
                                </button>
                            </div>
                        </div><!--end grid-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>

      <script type="text/javascript">
    $("#changePass").on("click", function() {
        $('#changePass').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop(
            'disabled',
            true);
        $.ajax({
            url: "<?=BASE_URL('ajaxs/client/changePassword.php');?>",
            method: "POST",
            dataType: "JSON",
            data: {
                token: $("#token").val(),
                action: "ChangePassword",
                password: $("#old_password").val(),
                newpassword: $("#new_password").val(),
                renewpassword: $("#confirm_new_password").val()
            },
            success: function(respone) {
                if (respone.status == 'success') {
            showMessageDucapi(respone.msg, "success");
                    setTimeout("location.href = '<?= BASE_URL('auth/logout'); ?>';", 100);
                } else {
                 
                  showMessageDucapi(respone.msg, "error");
                }
                $('#changePass').html('Change Password').prop('disabled',
                    false);
            },
            error: function() {
                cuteToast({
                    type: "error",
                    message: 'Không thể xử lý',
                    timer: 5000
                });
                $('#changePass').html('Change Password').prop('disabled',
                    false);
            }

        });
    });
</script>

        
<?php require_once __DIR__ . '/footer.php'; ?>