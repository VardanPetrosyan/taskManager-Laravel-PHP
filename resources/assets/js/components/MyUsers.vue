<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="container">

        <div class="btn-group btn-group-lg" style="width: 100%" role="group"
             aria-label="Large button group">
            <button type="button" v-on:click="usersTabs(0)"
                    :style="userPosition.type == 'director'?'width: 50%; padding-left: 5px;':'width: 50%; padding-left: 5px;'"
                    v-bind:class="tabIndex==0?'btn btn-success':'btn btn-default'">Պատասխանատուներ
            </button>
            <button type="button" v-on:click="usersTabs(1)"
                    :style="userPosition.type == 'director'?'width: 50%; padding-left: 5px;':'width: 50%; padding-left: 5px;'"
                    v-bind:class="tabIndex==1?'btn btn-success':'btn btn-default'">Ավելացնել Պատասխանատու
            </button>
        </div>
        <hr/>

        <section v-if="tabIndex==0">

            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անուն</th>
                                <th scope="col">Էլ հասցե</th>
                                <th scope="col">Կարգավիճակ</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պաշտոն</th>
                                <!--                                <th scope="col">Գույք.</th>-->
                                <th v-if="userPosition.type == 'director'" scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in showedUsers">
                                <th>{{items.name}}</th>
                                <th>{{items.email}}</th>
                                <td v-if="items.status == 'user'"> օգտատեր</td>
                                <td v-if="items.status == 'manager'"> մենեջեր</td>
                                <td v-if="items.status == 'admin'"> ադմին</td>
                                <td>{{ getSchool(items.categoryStructure) }}</td>
                                <td>{{getPositionUser(items.position)}}</td>
                                <td v-if="userPosition.type == 'director'" style="text-align: center"
                                    class="confirm-block-control">
                                    <button v-if="items.status != 'ordered'" class="btn btn-sm btn-warning"
                                            v-on:click="editExists(index)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.status != 'ordered'" class="btn btn-sm btn-danger"
                                            v-on:click="deleteExists(index)">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                        <div v-if="openAddBlockExists" class="col-xs-12 jumbotron"
                             style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0px 0px 5px 2px;">
                            <div class="col-xs-6">
                                <div class="col-xs-6">
                                    <label>Անուն</label>
                                    <input id="user-name-exists" class="form-control" v-on:keyup="nameChange"
                                           :value="oneOrderExists?oneOrderExists.name:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Էլ հասցե</label>
                                    <input id="user-email-exists" v-on:change="emailChange"
                                           class="form-control" :value="oneOrderExists?oneOrderExists.email:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Բաժին</label>
                                    <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->
                                    <select class="form-control" id="user-categoryStructure-exists">
                                        <option :value="oneOrderExists.categoryStructure" selected hidden>
                                            {{getSchool(oneOrderExists.categoryStructure)}}
                                        </option>
                                        <option v-for="schoolParent in schoolsParent" :value="schoolParent">{{
                                            getSchool(schoolParent)}}
                                        </option>
                                        <option :value="user.categoryStructure_id">{{
                                            getSchool(user.categoryStructure_id)}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label>Պաշտոն</label>
                                    <select id="user-position-exists" class="form-control">
                                        <option :value="oneOrderExists.position" selected hidden>{{getPositionUser(oneOrderExists.position)}}
                                        </option>
                                        <option v-for="position in myPositionUser" v-bind:value="position.id">
                                            {{position.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label>Կարգավիճակ</label>
                                    <select class="form-control" id="user-status-exists">
                                        <option value="user">օգտատեր</option>
                                        <option value="manager">մենեջեր</option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label>Գաղտնաբառ</label>
                                    <input id="user-password-exists" v-on:change="countChange"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-6">

                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="updateExists()">Պահպանել
                                    </button>
                                    <button class="btn btn-danger" style="float: right" v-on:click="cancelExists">
                                        Չեղարկել
                                    </button>
                                </div>
                            </div>
                        </div>


                        <p style="text-align:center">
                            <v-progress-circular
                                    v-if="loading"
                                    align="center"
                                    :width="5"
                                    :size="80"
                                    color="green"
                                    indeterminate
                            ></v-progress-circular>
                        </p>


                    </div>
                </div>
            </div>
            <div class="col-xs-12" style="text-align: center" v-if="myUsers.length>10">
                <paginate
                        v-model="page"
                        :page-count="Math.floor(myUsers.length/10+1)"
                        :page-range="3"
                        :margin-pages="2"
                        :click-handler="goToPage"
                        :prev-text="'Նախորդ'"
                        :next-text="'Հաջորդ'"
                        :container-class="'pagination'"
                        :page-class="'page-item'">
                </paginate>
            </div>
        </section>
        <section v-else-if="tabIndex==1">
            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-12 jumbotron"
                             style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0px 0px 5px 2px;">
                            <div class="col-xs-6">

                                <div class="col-xs-6">
                                    <label>Անուն</label>
                                    <input id="users-name" class="form-control" :value="''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Էլ հասցե</label>
                                    <input id="users-email" class="form-control" :value="''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Կարգավիճակ</label>
                                    <select class="form-control" id="users-status">
                                        <option value="user">օգտատեր</option>
                                        <option value="manager">մենեջեր</option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label>Բաժին</label>
                                    <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->
                                    <select class="form-control" id="users-categoryStructure">
                                        <option v-for="schoolParent in schoolsParent" :value="schoolParent">{{
                                            getSchool(schoolParent)}}
                                        </option>
                                        <option :value="user.categoryStructure_id">{{
                                            getSchool(user.categoryStructure_id)}}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-xs-6">
                                    <label>Պաշտոն</label>
                                    <select id="users-position" class="form-control">
                                        <option v-for="position in myPositionUser" v-bind:value="position.id">
                                            {{position.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label>Գաղտնաբառ</label>
                                    <input id="users-password" class="form-control">
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="save">Ավելացնել
                                    </button>
                                    <button class="btn btn-danger" style="float: right" v-on:click="add">Չեղարկել
                                    </button>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <p style="color:green">{{message}}</p>
                                <p style="color:red" v-for="ietm in errorMesage">{{ietm}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>


</template>
<script>

    import JsonExcel from 'vue-json-excel';

    import $ from "jquery";

    import Multiselect from 'vue-multiselect';
    import VueRangedatePicker from 'vue-rangedate-picker';
    import Paginate from 'vuejs-paginate';

    export default {
        name: "MyUsers",
        data() {
            return {
                myOrderedFurn: [],
                historyFurn: [],
                valid: true,
                sendedFurn: [],
                orderedFurn: [],
                sendCount: 0,
                sendCountValid: false,
                sendSchool: 0,
                sendSchoolValid: false,
                sendTouched: false,
                sendingFurn: null,
                userPosition: [],
                confirmingFurniture: null,
                myUsers: [],
                myPositionUser: [],
                tabIndex: 0,
                page: 0,
                pageHistory: 0,
                workers: [],
                user: JSON.parse(localStorage.getItem("user")),
                usernames: [],
                openAddBlock: false,
                openAddBlockExists: false,
                orderData: [],
                nameValid: true,
                message:'',
                errorMesage:{
                    name:'',
                    email:'',
                    password:'',
                    passlength:'',
                    dublEmail:''
                },
                passwordValid:true,
                emailValid: true,
                categoryValid: true,
                passwordLengthValid:true,
                showedUsers: [],
                showedHistory: [],
                updatedDataExists: {},
                createdData: {},
                // schoolValid:true,
                reasonValid: true,
                loading: false,
                oldvalues: {},
                oneOrder: {
                    school: 'null',
                    user: 'null',
                    category: 'null',
                    status: 'null',
                },
                oneOrderExists: {
                    name: 'null',
                    email: 'null',
                    categoryStructure: 'null',
                    position: 'null',
                    status: "null",
                    oldIndex: "null"

                },
                schools: [],
                schoolsParent: [],
                categories: [],

            }
        },

        mounted() {
            this.getUsernames();
            this.getSchools();
            this.getCategories();
            this.getWorkers();
            this.getMyUsers();
        },

        updated() {

        },


        components: {
            Multiselect,
            VueRangedatePicker,
            downloadExcel: JsonExcel,
            Paginate
        },


        methods: {
            getUsernames() {
                let id = this.user.position;
                var url = `auth/getUsernames/${id}`;

                axios.get(url)
                    .then((response) => {
                        this.usernames = response.data.data;
                        this.userPosition = response.data.position;
                        this.getMyUsers()
                    });

                // console.log(this.usernames);
            },

            goToPage(pageNum) {
                console.log("page = ", pageNum);
                this.page = pageNum;

                this.showedUsers = this.myUsers.slice((pageNum - 1) * 10, ((pageNum - 1) * 10) + 10);
                // this.productSorting();
            },


            cancelOrder(index) {
                const cancelingOrder = this.orderedFurn[index];


                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: cancelingOrder};

                var url = 'auth/cancel/order/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    if (response.data.success) {
                        this.getMyUsers();
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            getWorkers() {
                if (this.userPosition.type == 'director') {
                    let school_id = this.user.categoryStructure_id;
                    var url = '/auth/getWorkers/' + school_id;
                    axios.get(url)
                        .then((response) => {
                            this.workers = response.data.data;
                            this.getMyUsers()
                        });
                }
                // console.log(this.usernames);
            },
            getUsername(myid) {
                let username = null;
                let id = parseInt(myid);
                this.usernames.forEach(function (value) {
                    if (value.id == id) {
                        username = value.name;
                        return '';
                    }
                });
                return username;
            },
            edit(id) {
                this.oneOrder = {
                    name: this.orderData[id].name,
                    count: this.orderData[id].count,
                    category: this.orderData[id].category,
                    school: this.orderData[id].school,
                    reason: this.orderData[id].reason,
                    status: this.orderData[id].status,
                    user: this.orderData[id].user,
                };
                this.openAddBlock = true;
                this.remove(id);
            },

            editExists(id) {

                this.cancelExist();

                this.oneOrderExists = this.showedUsers[id];
                this.oneOrderExists.oldIndex = id;
                this.openAddBlockExists = true;
                this.removeExists(id);
            },

            confirmExists(id) {
                this.confirmingFurniture = this.sendedFurn[id];

                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: this.confirmingFurniture};

                var url = 'auth/confirm/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    console.log('asd', response);
                    if (response.data.success) {
                        this.getMyUsers();
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },

            updateExists() {

                // this.loading = true;

                var name = document.getElementById('user-name-exists');
                var email = document.getElementById('user-email-exists');
                var categoryStructure = document.getElementById('user-categoryStructure-exists');
                var position = document.getElementById('user-position-exists');
                var status = document.getElementById('user-status-exists');
                let password = document.getElementById('user-password-exists');

                // var user_id = !user ? this.user.id : (user.value == 'null') ? this.user.id : user.value;


                this.updatedDataExists = {
                    name: name.value,
                    email: email.value,
                    categoryStructure: categoryStructure.value,
                    position: position.value,
                    status: status.value,
                    password: password.value,
                    id: this.oneOrderExists.id
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {newData: this.updatedDataExists, oldData: this.oneOrderExists};

                var url = 'auth/update/users';
                axios.post(
                    url,
                    data,
                )
                    .then((response) => {

                        if (response.data.success) {
                            // console.log('asd', response);
                            this.getMyUsers();
                            this.openAddBlockExists = false;
                            this.loading = false;
                        }
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });


                this.loading = false;
            },

            deleteExists(index) {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                const userId = this.showedUsers[index].id;

                var data = {userId: userId};

                var url = 'auth/delete/users';
                axios.post(
                    url,
                    data,
                )
                    .then((response) => {
                        // console.log('asd', response);
                        if (response.data.success) {
                            // this.removeExists(index);
                            this.getMyUsers();
                        }
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },

            sendExists(index) {
                this.sendingFurn = this.myOrderedFurn[index];
                this.sendingFurn.oldIndex = index;
            },

            sendFurn() {

                // this.sendTouched = true;
                // this.sendSchoolValid = this.sendSchool != 0;
                // this.sendCountValid = parseInt(this.sendCount)!= 0 && parseInt(this.sendCount) <= this.sendingFurn.count;
                //
                // if(!this.sendSchoolValid || !this.sendCountValid){
                //     return;
                // }

                var user = JSON.parse(localStorage.getItem("user"));

                if (!user) {
                    return false;
                }

                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var url = 'auth/send/furniture';

                const data = {
                    // sendCount: this.sendCount,
                    // sendSchoolId: this.sendSchool,
                    furniture: this.sendingFurn,
                };

                axios.post(
                    url,
                    data,
                )
                    .then((response) => {
                        if (response.data.success) {
                            this.getMyUsers();
                            // this.sendCount = 0;
                            // this.sendCountValid = false;
                            // this.sendSchool = 0;
                            // this.sendSchoolValid = false;
                            this.showedUsers[this.sendingFurn.oldIndex] = false;
                            this.sendingFurn = null;
                            // this.sendTouched = false;
                        }
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });


            },



            getCategory(myid) {
                let cat = null;
                let id = parseInt(myid);
                this.categories.forEach(function (value) {
                    if (value.id == id) {
                        cat = value.name;
                        return '';
                    }
                });
                return cat;
            },
            getSchool(myid) {
                let school = null;
                let id = parseInt(myid);
                this.schools.forEach(function (value) {
                    if (value.id == id) {
                        school = value.category;
                        return '';
                    }
                });
                return school;
            },
            codeChange(event) {
                this.oldvalues.code = event.target.value;
            },
            nameChange(event) {
                this.oldvalues.name = event.target.value;
            },
            emailChange(event) {
                this.oldvalues.email = event.target.value;
            },

            countSendChange(event) {
                this.sendCount = event.target.value;
            },

            reasonChange(event) {
                this.oldvalues.reason = event.target.value;
            },

            remove(id) {
                // console.log('data:', this.orderData);
                // console.log('id:', id);
                if (!id && this.openAddBlock) {
                    // this.openAddBlock = false;
                }

                this.orderData.splice(id, 1);
                // console.log('data:', this.orderData);
            },
            usersTabs(index) {
                this.tabIndex = index;
            },
            removeExists(id) {
                this.showedUsers.splice(id, 1);
            },

            cancelExists() {
                this.openAddBlockExists ? this.openAddBlockExists = false : this.openAddBlockExists = true;

                const oldIndex = this.oneOrderExists.oldIndex;
                delete this.oneOrderExists.oldIndex;

                this.showedUsers.splice(oldIndex, 0, this.oneOrderExists);
                this.oneOrderExists = {};
            },

            cancelExist() {
                this.openAddBlockExists ? this.openAddBlockExists = false : this.openAddBlockExists = true;
                delete this.oneOrderExists.oldIndex;
                this.oneOrderExists = {};
            },



            save() {
                var name = document.getElementById('users-name');
                var email = document.getElementById('users-email');
                var status = document.getElementById('users-status');
                var categoryStructure = document.getElementById('users-categoryStructure');
                var position = document.getElementById('users-position');
                var password = document.getElementById('users-password');

                !name.value ? this.nameValid = false : this.nameValid = true;
                !email.value ? this.emailValid = false : this.emailValid = true;
                !password.value ? this.passwordValid = false : this.passwordValid = true;
                password.value.length < 8 ? this.passwordLengthValid  = false : this.passwordLengthValid = true;

                !this.nameValid ? this.errorMesage.name = "Անուն դաշտը պարտադիր է" :this.errorMesage.name = "";
                !this.emailValid ? this.errorMesage.email = "Էլ հասցե դաշտը պարտադիր է" :this.errorMesage.email = "";
                !this.passwordLengthValid ? this.errorMesage.password = "Գաղտնաբառը կարճ է" :this.errorMesage.password = "";
                !this.passwordValid ? this.errorMesage.passlength = "Գաղտնաբառ դաշտը պարտադիր է" :this.errorMesage.passlength = "";

                if (this.nameValid && this.emailValid && this.passwordValid && this.passwordLengthValid ) {
                    this.createdData = {
                        name: name.value,
                        email: email.value,
                        status: status.value,
                        categoryStructure: categoryStructure.value,
                        position: position.value,
                        password: password.value
                    };
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;


                    var data = this.createdData;

                    var url = 'auth/add/users';


                    axios.post(
                        url,
                        {data: data},
                    )
                        .then((response) => {

                            if(response.data.success){
                                this.message = 'Պատասխանատուն ստեղծված է';
                                setTimeout(() => this.message = '',5000);


                                this.getMyUsers();
                            }else{
                                this.errorMesage.dublEmail = response.data.error
                                setTimeout(() => this.errorMesage.dublEmail = '',5000);
                            }

                        })
                        .catch((e) => {

                            console.log("exception", e);
                        });

                }
        },

            add() {
                this.openAddBlock ? this.openAddBlock = false : this.openAddBlock = true
            },
            getSchools() {
                var url = "auth/categoriesStructure";
                axios.post(
                    url,
                )
                    .then((data) => {
                        this.schools = data.data;
                        this.getMyUsers();
                        for (let school of data.data) {
                            if (school.parent_category_id == this.user.categoryStructure_id) {
                                this.schoolsParent.push(school.id);
                            }
                        }
                    })
                    .catch((e) => {
                    });
            },
            getCategories() {
                var _this = this;
                var url = "/auth/getFurnitureCategories";
                axios.get(url).then(function (data) {
                    _this.categories = data.data;
                    this.getMyUsers()
                }).catch(function (e) {
                    console.log('exception', e);
                });
            },
            selectSchool(data) {
                this.orderData.school = data;
            },



            getPositionUser(id) {
                let position = null;
                this.myPositionUser.forEach((item) => {
                        if (item.id == id) {
                            position = item.name;
                            return '';
                        }
                    }
                )
                return position;
            },

            getMyUsers() {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/my/users";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {categoryStructure_id: user.categoryStructure_id},
                )
                    .then((response) => {

                        this.myUsers = response.data.data;
                        this.myPositionUser = response.data.position;
                        this.goToPage(1);

                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },


            logout() {
                this.$router.go("Login");
                this.$store.dispatch('logout');
            },
        }
    }

</script>

<style scoped>


</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
