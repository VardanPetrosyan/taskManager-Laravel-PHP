<template>
    <!--<div class="h-screen flex justify-center items-center">-->
    <!--<Head/>-->
    <!--<div class="w-full max-w-xs">-->
    <!--<h1 class="text-center mb-6">Login</h1>-->

    <!--<form @submit.prevent="login" @keydown="form.errors.clear($event.target.name)" class="form-card">-->
    <!--<div class="mb-4">-->
    <!--<label class="block text-grey-darker text-sm font-bold mb-2" for="email">Email</label>-->

    <!--<input v-focus v-model="form.email" class="form-control"-->
    <!--:class="{ 'border-red mb-3' : form.errors.has('email') }" id="email" type="email"-->
    <!--name="email" placeholder="Email"/>-->
    <!--<p v-if="form.errors.has('email')" class="text-red text-xs italic">-->
    <!--{{ form.errors.get('email') }}-->
    <!--</p>-->
    <!--</div>-->

    <!--<div class="mb-6">-->
    <!--<label class="block text-grey-darker text-sm font-bold mb-2" for="password">Password</label>-->

    <!--<input v-model="form.password" class="form-control"-->
    <!--:class="{ 'border-red mb-3' : form.errors.has('password') }" id="password" type="password"-->
    <!--name="password" placeholder="Password"/>-->
    <!--<p v-if="form.errors.has('password')" class="text-red text-xs italic">{{ form.errors.get('password')-->
    <!--}}</p>-->
    <!--</div>-->

    <!--<button class="btn btn-primary" type="submit" :disabled="this.isDisabled"-->
    <!--:class="{ 'opacity-50 cursor-not-allowed': this.isDisabled }">-->
    <!--<i v-if="isLoading" class="fa fa-spinner fa-spin fa-fw"></i>-->
    <!--Sign In-->
    <!--</button>-->

    <!--<div class="mt-4 text-sm">-->
    <!--Don't have an account?-->
    <!--<router-link class="inline-block font-bold text-indigo hover:text-indigo-darker" to="/register"-->
    <!--exact>-->
    <!--Register now-->
    <!--</router-link>-->
    <!--</div>-->
    <!--</form>-->
    <!--</div>-->
    <!--</div>-->


    <div class="container">
        <Head/>
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel1-success">
                <div class="phanel-heading" style="text-align: center">
                    <h1>Մուտք գործել</h1>
                    <!--<a href="#">Forgot password?</a>-->
                </div>

                <div style="padding-top:30px" class="panel-body">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form @submit.prevent="login" @keydown="form.errors.clear($event.target.name)"
                          class="form-horizontal" role="form">
                        <p v-if="form.errors.has('email')" class="text-red text-xs italic">Անվավեր էլեկտրոնային հասցե կամ գաղտնաբառ</p>
                        <div style="margin-bottom: 25px" class="input-group">
                             <span class="input-group-addon" style="padding-right: 20px">
                                <i class="fa fa-user"></i>
                             </span>
                            <input v-focus v-model="form.email" id="login-username" type="text" class="form-control" :class="{ 'border-red mb-3' : form.errors.has('email') }" placeholder="Օգտանուն">
                        </div>
                        <!--<p v-if="form.errors.has('email')" class="text-red text-xs italic">{{ form.errors.get('email') }}</p>-->

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon" style="padding-right: 20px">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input v-model="form.password" id="login-password" type="password" class="form-control"
                                   :class="{ 'border-red mb-3' : form.errors.has('password') }" name="password"
                                   placeholder="Գաղտնաբառ">
                            <p v-if="form.errors.has('password')" class="text-red text-xs italic">{{
                                form.errors.get('password') }}</p>
                        </div>


                        <!--<div class="input-group">-->
                        <!--<div class="checkbox">-->
                        <!--<label>-->
                        <!--<input id="login-remember" type="checkbox" name="remember" value="1"> Հիշիր ինձ-->
                        <!--</label>-->
                        <!--</div>-->
                        <!--</div>-->


                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button type="submit" id="btn-login" class="btn btn-success">Մուտք</button>
                                <i v-if="isLoading" class="fa fa-spinner fa-spin fa-fw"></i>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                    <!--Հաշիվ չունեք!-->
                                    <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                        <!--Գրանցվել այստեղ-->

                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Form from '../utils/Form';
    import Head from "./includes/Head";

    export default {
        components: {
            Head
        },
        data() {
            return {
                form: new Form({
                    email: '',
                    password: ''
                }),
                isLoading: false
            }
        },
        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            }
        },
        methods: {
            login() {
                if (this.isDisabled) {
                    return false
                }
                this.isLoading = true;
                this.form.post('auth/login')
                    .then(data => {
                        if (data.role != "user") {
                            if(data.role == "manager"){
                                this.$store.dispatch('login', data);
                                localStorage.setItem("user", JSON.stringify(data.user));
                            }

                            window.location.href = "/" + data.role + "/dashboard";
                        } else {
                            this.$store.dispatch('login', data);
                            localStorage.setItem("user", JSON.stringify(data.user));
                        }
                    })
                    .catch(() => {
                        this.isLoading = false;
                        this.form.password = '';
                    })
            }
        }
    }
</script>