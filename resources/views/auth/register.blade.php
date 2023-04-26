@extends('frontend.layout.app')

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>تسجيل مستخدم</h2>
                            <ul>
                                <li><a href="index.html">الرئيسية</a></li>
                                <li><i class="fa fa-angle-double-left"></i></li>
                                <li><a href="javascript:void(0)">تسجيل مستخدم</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="login-page section-big-py-space b-g-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4">
                    <div class="theme-card">
                        <form class="theme-form">
                            <div class="row g-3">
                                <div class="col-md-12 form-group">
                                    <label for="email">الاسم الاول</label>
                                    <input type="text" class="form-control" id="fname" placeholder="الاسم الاول"
                                        required="">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="review">الاسم الاخير</label>
                                    <input type="text" class="form-control" id="lname" placeholder="الاسم الاخير"
                                        required="">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12 form-group">
                                    <label>الهاتف </label>
                                    <input type="text" class="form-control" placeholder=" الهاتف" required="">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>البريد الالكتروني</label>
                                    <input type="text" class="form-control" placeholder="البريد الالكتروني"
                                        required="">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>كلمة المرور</label>
                                    <input type="password" class="form-control" placeholder="كلمة المرور" required="">
                                </div>
                                <div class="col-md-12 form-group"><a href="javascript:void(0)" class="btn btn-normal">انشاء
                                        حساب جديد</a></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12 ">
                                    <p>لديك حساب بالفعل <a href="login.html" class="txt-default">اضغط</a> هنا &nbsp;<a
                                            href="login.html" class="txt-default">دخول</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
