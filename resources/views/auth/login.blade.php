@extends('frontend.layout.app')

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2> دخول المستخدمين</h2>
                            <ul>
                                <li><a href="index.html">الرئيسية</a></li>
                                <li><i class="fa fa-angle-double-left"></i></li>
                                <li><a href="javascript:void(0)">دخول المستخدمين</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->

    <!--section start-->
    <section class="login-page section-big-py-space b-g-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
                    <div class="theme-card">
                        <form class="theme-form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>البريد الالكتروني</label>
                                <input type="email" class="form-control" placeholder="البريد الالكتروني" value="{{ old('email') }}" required="" name="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>كلمة المرور</label>
                                <input type="password" class="form-control" placeholder="كلمة المرور" required="" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> تذكرني
                                </div>
                            </div>
                            <button type="submit" class="btn btn-normal">دخول</button>
                            <a class="float-end txt-default mt-2" href="forget-pwd.html">نسيت كلمة المرور</a>
                        </form>

                        <a href="register.html" class="txt-default pt-3 d-block">تسجيل مستخدم جديد</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
