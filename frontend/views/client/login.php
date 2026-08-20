<?php
$title = 'TRANG CHỦ | ' . $VCD->site('title');
$body['header'] = '
';
$body['footer'] = '

';
require_once __DIR__ . '/../../../core/is_user.php';
require_once __DIR__ . '/header.php';
//CheckLogin();
?><body class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

<div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
    <div wire:snapshot="{&quot;data&quot;:{&quot;email&quot;:null,&quot;password&quot;:null},&quot;memo&quot;:{&quot;id&quot;:&quot;9JEqkq8pnoZrmi3M3ggX&quot;,&quot;name&quot;:&quot;auth.login&quot;,&quot;path&quot;:&quot;auth\/login&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;a85402b61207e7b16ef8b87c3f7fb1f68db1b017add24407b504baac1362260c&quot;}" wire:effects="[]" wire:id="9JEqkq8pnoZrmi3M3ggX" class="grid grid-cols-1 gap-0 lg:grid-cols-12">
    <div class="lg:col-span-5">
        <div class="!px-12 !py-12 card-body">

            <div class="text-center">
                <h4 class="mb-2 text-purple-500 dark:text-purple-500">Chào mừng trở lại!</h4>
                <p class="text-slate-500 dark:text-zink-200">Đăng nhập để tiếp tục đến Sellrobux.</p>
            </div>

            <form wire:submit="login" method="post" class="mt-10">
                <input type="hidden" name="_token" value="jtGTKZxER6ONMeziG6EOBtw6cSeIqzZbLLeMphvc" autocomplete="off">                <div class="mb-3">
                    <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
                    <input type="email" wire:model="email" id="email" name="email" class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Nhập email">
                 
                </div>
                <div class="mb-3">
                    <label for="password" class="inline-block mb-2 text-base font-medium">Mật khẩu</label>
                    <input type="password" id="password" wire:model="password" name="password" class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Nhập mật khẩu">
         
                    <div>
                        <div class="flex items-center gap-2">
                            <input id="checkboxDefault1" class="border rounded-sm appearance-none size-4 bg-slate-100 border-slate-200 dark:bg-zink-600/50 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox" value="">
                            <label for="checkboxDefault1" class="inline-block text-base font-medium align-middle cursor-pointer">Ghi nhớ tài khoản</label>
                        </div>

                    </div>
                    <div class="mt-10">
                        <button type="submit"  id="btnLogin" wire:loading.class="opacity-50" class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            Đăng nhập
                        </button>
                    </div>

                    <div class="mt-10 text-center">
                        <p class="mb-0 text-slate-500 dark:text-zink-200">Bạn chưa có tài khoản? <a href="<?= BASE_URL(''); ?>auth/register" wire:navigate="" class="font-semibold underline transition-all duration-150 ease-linear text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500">
                                Đăng kí</a></p>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 card bg-white/60 dark:bg-zink-500/60">
        <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">
            <div class="flex items-center justify-between gap-3">

                <div class="shrink-0">
                    <div class="relative dropdown text-end">

                    </div>
                </div>
            </div>
            <div class="mt-auto">
                <img src="<?= BASE_URL('public') ?>/assets/images/img-01.png" alt="" class="md:max-w-[32rem] mx-auto">
            </div>
        </div>
    </div>
</div>
</div>
 <script>
        $("#btnLogin").on("click", function () {
            $('#btnLogin').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
            $.ajax({
                url: "<?= BASE_URL('ajaxs/client/login.php'); ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    email: $("#email").val(),
                    password: $("#password").val(),
                },
                success: function (res) {
                    if (res.status == 'success') {
                
                     setTimeout("location.href = '<?= BASE_URL(''); ?>';", 100);
                    } else {
                   showMessageDucapi(res.msg, res.status);
                    }
                    $('#btnLogin').html('Đăng nhập').prop('disabled', false);
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
<script src="/livewire/livewire.min.js?id=38dc8241" data-csrf="jtGTKZxER6ONMeziG6EOBtw6cSeIqzZbLLeMphvc" data-update-uri="/livewire/update" data-navigate-once="true"></script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'901cfa3ccefa03d3',t:'MTczNjg1MDkwOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>

<iframe height="1" width="1" style="position: absolute; top: 0px; left: 0px; border: none; visibility: hidden;"></iframe></body>