<script src="home/armen/Desktop/Grigor js/assets/js/script.js"></script>
<template>

    <div class="container">

        <div class="btn-group btn-group-lg" style="width: 100%" role="group"
             aria-label="Large button group">
            <button type="button" v-on:click="furnitureTabs(0)"
                    :style="'width: 100%; padding-left: 5px;'"
                    v-bind:class="tabIndex==0?'btn btn-success':'btn btn-default'">Գոյքի Պատվերներ
            </button>
        </div>
        <hr/>

        <section v-if="tabIndex==0">

            <div class="container confirm-block" >
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անուն</th>
                                <th scope="col">Կատեգորիա</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col">Քանակ</th>
                                <th scope="col">Կարգավիճակ.</th>
                                <th scope="col">Պատվիրող</th>
                                <th scope="col">Պատվիրման օր</th>
                                <th scope="col"></th>
                                <th scope="col" style="min-width: 85px">Կարգավորում</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in showedFurniture">
                                <th>{{items.name}}</th>
                                <td>{{ getCategory(items.category_id) }}</td>
                                <td>{{ getSchool(items.categoryStructure_id) }}</td>
                                <td>{{ getUsername(items.user_id)}}</td>
                                <td>{{items.count}}</td>
                                <td v-if="items.status == 'ordered'"> Պատվիրված </td>
                                <td>{{getSchool(items.ordered_from_categoryStructure_id) }}</td>
                                <td>{{items.created_at}}</td>
                                <td v-if="!items.approved && items.status != 'sended'"> Չհաստատված </td>
                                <td v-if="items.approved && items.status == 'ordered'"> Հաստատված </td>
                                <td style="text-align: center"
                                    class="confirm-block-control">
                                    <button v-if="!items.approved && items.status != 'sended'"  title="Հաստատել"
                                            class="btn btn-sm btn-success"
                                            v-on:click="confirmExists(index)">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.approved && items.status == 'ordered'" title="Չեղարկել"
                                            class="btn btn-sm btn-warning"
                                            v-on:click="cancelOrderExists(index)">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </button>
                                    <button  title="Մեռժել" class="btn btn-sm btn-danger"
                                            v-on:click="deleteOrderExists(index)">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>

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
            <div class="col-xs-12" style="text-align: center" v-if="furnitures.length>10">
                <paginate
                        v-model="page"
                        :page-count="Math.floor(furnitures.length/10+1)"
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



    </div>


</template>
<script>

    import JsonExcel from 'vue-json-excel';
    import Multiselect from 'vue-multiselect';
    import VueRangedatePicker from 'vue-rangedate-picker';
    import Paginate from 'vuejs-paginate';

    export default {
        name: "OrdersFurniture",
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
                furnitures: [],
                tabIndex: 0,
                page: 0,
                pageHistory: 0,
                workers: [],
                user: JSON.parse(localStorage.getItem("user")),
                usernames: [],
                orderData: [],
                nameValid: true,
                statusValid: true,
                userValueValid: '',
                countValid: true,
                countUnnecessaryValid: true,
                categoryValid: true,
                showedFurniture: [],
                showedHistory: [],
                updatedDataExists: {},
                newValuesStatus: {},
                newValuesEdit: {},
                newValuesTransfer: {},
                // schoolValid:true,
                reasonValid: true,
                loading: false,
                oldvalues: {},
                oneOrder: {
                    school: 'null',
                    user: 'null',
                    category: 'null',
                    // status: 'null',
                },
                oneOrderExists: {
                    school: 'null',
                    user: 'null',
                    category: 'null',
                    // status: 'null',
                },
                schools: [],
                schoolsParent: [],
                categories: [],

                json_meta: [
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8'
                        }
                    ]
                ]
            }
        },

        mounted() {
            this.getUsernames();
            this.getSchools();
            this.getCategories();
            this.getWorkers();
            this.getMyFurnitures();
        },

        updated() {

        },


        components: {
            Multiselect,
            VueRangedatePicker,
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
                        this.getMyFurnitures()
                    });

                // console.log(this.usernames);
            },


            goToPage(pageNum) {
                // console.log("page = ", pageNum);
                this.page = pageNum;

                this.showedFurniture = this.furnitures.slice((pageNum - 1) * 10, ((pageNum - 1) * 10) + 10);
                // this.productSorting();
            },

            goToPageHistory(pageNum) {
                // console.log("page = ", pageNum);
                this.pageHistory = pageNum;

                this.showedHistory = this.historyFurn.slice((pageNum - 1) * 10, ((pageNum - 1) * 10) + 10);
                // this.productSorting();
            },

            getWorkers() {
                if (this.userPosition.type == 'director') {
                    let school_id = this.user.categoryStructure_id;
                    var url = '/auth/getWorkers/' + school_id;
                    axios.get(url)
                        .then((response) => {
                            this.workers = response.data.data;
                            this.getMyFurnitures()
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

            deleteOrderExists(id) {
                this.oneOrderExists = this.showedFurniture[id];

                // console.log(this.showedFurniture[id]);
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: this.oneOrderExists.id};

                var url = 'auth/deleteOrder/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    // console.log('asd', response);
                    if (response.data.success) {
                        this.getMyFurnitures();
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            cancelOrderExists(id) {
                this.oneOrderExists = this.showedFurniture[id];

                // console.log(this.showedFurniture[id]);
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: this.oneOrderExists.id};

                var url = 'auth/cancelOrder/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    // console.log('asd', response);
                    if (response.data.success) {
                        this.getMyFurnitures();
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },

            confirmExists(id) {
                this.oneOrderExists = this.showedFurniture[id];

                // console.log(this.oneOrderExists.oldIndex = id);
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: this.oneOrderExists.id};

                var url = 'auth/confirmOrder/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    // console.log('asd', response);
                    if (response.data.success) {
                        this.getMyFurnitures();
                        this.oneOrderExists={};
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

            sendData() {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;


                var data = this.orderData;

                var url = 'auth/add/furniture';


                axios.post(
                    url,
                    {user_id: user.id, data: data},
                )
                    .then((response) => {
                        this.furnitures = this.furnitures.concat(response.data.data);
                        const countNoShowed = 10 - this.showedFurniture.length;
                        let concatData = [];
                        // console.log(countNoShowed);
                        if (countNoShowed) {
                            response.data.data.forEach(function (item, i) {
                                // console.log(i, item);
                                if (i == countNoShowed) {
                                    return;
                                }
                                concatData.push(item);
                            });

                            if (concatData.length) {
                                this.showedFurniture = this.showedFurniture.concat(concatData);
                            }
                        }
                        this.getMyFurnitures();
                        this.orderData = [];
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            remove(id) {
                console.log('data:', this.orderData);
                console.log('id:', id);
                if (!id && this.openAddBlock) {
                    // this.openAddBlock = false;
                }

                this.orderData.splice(id, 1);
                console.log('data:', this.orderData);
            },


            getSchools() {
                var url = "auth/categoriesStructure";
                axios.post(
                    url,
                )
                    .then((data) => {
                        this.schools = data.data;
                        this.getMyFurnitures();
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
                    this.getMyFurnitures()
                }).catch(function (e) {
                    console.log('exception', e);
                });
            },


            furnitureTabs(index) {
                this.tabIndex = index;
            },


            getMyFurnitures() {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/orderAll/furniture";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {user_id: user.id},
                )
                    .then((response) => {

                        // _____________________________________
                        this.furnitures = response.data.data;

                        // _____________________________________
                        this.goToPage(1);
                        this.goToPageHistory(1);
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
    .input-date {
        width: 100% !important;
    }


</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
