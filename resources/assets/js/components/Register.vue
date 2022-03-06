<template>

    <div class="container">
        <Head/>
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">


            <div class="panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Մուտք գործել</div>
                </div>

                <div style="padding-top:30px" class="panel-body">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form @submit.prevent="register" @keydown="form.errors.clear($event.target.name)"
                          class="form-horizontal" :class="{ 'border-red mb-3' : form.errors.has('name') }" role="form">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon" style="padding-right: 20px">
                                <i class="fa fa-user"></i></span>
                            <input v-focus v-model="form.name" id="login-username" type="text" class="form-control"
                                   name="username" value="" placeholder="username">
                            <p v-if="form.errors.has('name')" class="">{{ form.errors.get('name') }}</p>
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon" style="padding-right: 20px">
                                <i class="fa fa-envelope" style="font-size: 11px"></i>
                            </span>
                            <input v-model="form.email" id="email" type="email" class="form-control"
                                   :class="{ 'border-red mb-3' : form.errors.has('email') }" placeholder="Email">
                            <p v-if="form.errors.has('email')" class="">{{ form.errors.get('email') }}</p>
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon" style="padding-right: 20px">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input v-model="form.password" :class="{ 'border-red mb-3' : form.errors.has('password') }"
                                   type="password" class="form-control" placeholder="password">
                            <p v-if="form.errors.has('password')" class="">{{ form.errors.get('password') }}</p>
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon" style="padding-right: 20px">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input v-model="form.password_confirmation" id="confirm-password" type="password"
                                   class="form-control" placeholder="password confirm">
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
                                <button type="submit" id="btn-login" :disabled="this.isDisabled"
                                        :class="{ 'opacity-50 cursor-not-allowed': this.isDisabled }"
                                        class="btn btn-success">Մուտք
                                </button>
                                <i v-if="isLoading" class="fa fa-spinner fa-spin fa-fw"></i>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                    Հաշիվ չունեք!
                                    <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                        Գրանցվել այստեղ
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

    import Form from '../utils/Form'
    import Head from "./includes/Head"


    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }),
                isLoading: false,
                error: false
            }
        },
        components: {
            Head
        },

        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            }
        },

        methods: {
            register() {
                if (this.isDisabled) {
                    return false
                }

                this.isLoading = true
                this.error = null

                this.form.post('auth/register')
                    .then(data => this.$store.dispatch('login', data))
                    .catch(error => {
                        this.isLoading = false
                        this.error = error

                        this.form.password = ''
                        this.form.password_confirmation = ''
                    })
            }
        }
    }
</script>
