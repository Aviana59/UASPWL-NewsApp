@extends('templates.admin.layouts.blank')
@section('admin-section')
<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>

                            <form onsubmit="event.preventDefault(); login()">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="/register">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    async function login() {
        const email = $('#email').val()
        const password = $('#password').val()
        const data = {
            email,
            password
        }
        console.log(data);
        try {
            const response = await axios.post('<?= url('login') ?>', data, {
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                }
            })
            window.location.href = "/admin";
        } catch (error) {
            console.log(error);
            Swal.fire({
                toast: true,
                position: "top-end",
                timer: 1500,
                title: error.response.data.message,
                showConfirmButton: false,
                icon: "error",
            })
        }
    }
</script>
@endSection()