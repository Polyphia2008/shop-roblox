<?php
$title = 'TRANG CHỦ | ' . $VCD->site('title');
$body['header'] = '
';
$body['footer'] = '

';
require_once __DIR__ . '/../../../core/is_user.php';
require_once __DIR__ . '/header.php';
//CheckLogin();
?>
<body class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

<div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
    <div wire:snapshot="{&quot;data&quot;:{&quot;email&quot;:null,&quot;password&quot;:null,&quot;name&quot;:null,&quot;password_confirmation&quot;:null},&quot;memo&quot;:{&quot;id&quot;:&quot;8Qz6yAaSnnaqNSpvSlIk&quot;,&quot;name&quot;:&quot;auth.register&quot;,&quot;path&quot;:&quot;auth\/register&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;e02ff42b6894cd3c1bedde3dd0ea6cec64f7411d130e2e0cdf5dbe636d442afe&quot;}" wire:effects="[]" wire:id="8Qz6yAaSnnaqNSpvSlIk" class="grid grid-cols-1 gap-0 lg:grid-cols-12">

    <div class="lg:col-span-5">
        <div class="!px-10 !py-12 card-body">
            <div class="text-center">
                <h4 class="mb-2 text-purple-500 dark:text-purple-500">Chào mừng trở lại!</h4>
                <p class="text-slate-500 dark:text-zink-200">Đăng nhập để tiếp tục đến Sellrobux.</p>
            </div>
            <div>
                <div class="mt-5 tab-content">
                    <div class="block tab-pane" id="emailTabs">
                        <form wire:submit="register" method="post" class="mt-10" id="signInForm">                            <div class="mb-3">
                                <label for="email-id-field" class="inline-block mb-2 text-base font-medium">Email</label>
                                <input type="email" id="email" wire:model="email" name="email" class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Nhập email">
                               
                            </div>
                            <div class="mb-3">
                                <label for="username-field" class="inline-block mb-2 text-base font-medium">Họ và tên</label>
                                <input type="text" id="username" wire:model="name" class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Nhập tên của bạn">
                              
                            </div>
                            <div class="mb-3">
                                <label for="password" class="inline-block mb-2 text-base font-medium">Mật khẩu</label>
                                <input type="password" id="password" wire:model="password" name="password" class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Nhập mật khẩu">
                              
                            </div>
                            <div class="mb-3">
                                <label for="password_re" class="inline-block mb-2 text-base font-medium">Nhập lại mật khẩu</label>
                                <input type="password" id="password_re" wire:model="password_confirmation" class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Nhập lại mật khẩu">
                              
                            </div>
                            <div class="mt-10">
                                <button type="submit" id="btnRegister"  wire:loading.class="opacity-50" class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    Đăng kí
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <p class="mb-0 text-slate-500 dark:text-zink-200">Bạn đã có tài khoản?<a href="<?= BASE_URL(''); ?>auth/login" wire:navigate="" class="font-semibold underline transition-all duration-150 ease-linear text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 card bg-white/60 dark:bg-zink-500/60">
        <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">

            <div class="mt-auto">
                <img src="<?= BASE_URL('public') ?>/assets/images/img-01.png" alt="" class="md:max-w-[32rem] mx-auto">
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $("#btnRegister").on("click", function() {
        $('#btnRegister').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',
            true);
        $.ajax({
            url: "<?= BASE_URL('ajaxs/client/register.php'); ?>",
            method: "POST",
            dataType: "JSON",
            data: {
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                password_re: $("#password_re").val(),
            },
                success: function(res) {
                if (res.status == 'success') {
                     setTimeout("location.href = '<?= BASE_URL(''); ?>';", 100);
                } else {
                     showMessageDucapi(res.msg, res.status);
                }
                $('#btnRegister').html('Đăng kí').prop('disabled',
                    false);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra . Vui lòng thử lại!'
                });
            }

        });
    });
</script>
<!-- FIX: /livewire/livewire.min.js KHONG TON TAI (tan tich tu template Laravel/Livewire). The script nay gay loi 404 tren MOI trang. Da vo hieu hoa. -->


</body>