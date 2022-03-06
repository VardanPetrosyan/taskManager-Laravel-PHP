<template>

    <nav class="top-bar animate-dropdown">

        <!--<div id="my-order-modal" class="modal fade" role="dialog">-->
            <!--<div class="modal-dialog">-->

                <!--<div class="modal-content">-->
                    <!--<div class="modal-header">-->
                        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                        <!--<h4 class="modal-title">Իմ պատվերների պատմությունը</h4>-->
                    <!--</div>-->
                    <!--<div class="modal-body" style="max-height: 80vh; overflow: auto" >-->
                        <!--<table id="example" class="table table-striped table-bordered" style="width:100%">-->
                            <!--<thead>-->
                            <!--<tr>-->
                                <!--<th>Անուն</th>-->
                                <!--<th>Քանակ</th>-->
                                <!--<th>Ստեղծվել է</th>-->
                                <!--<th>Կարգավիճակը</th>-->
                            <!--</tr>-->
                            <!--</thead>-->
                            <!--<tbody>-->
                            <!--<tr v-for="item in history">-->
                                <!--<td>{{ item.productName }}</td>-->
                                <!--<td>{{ item.count }}</td>-->
                                <!--<td>{{ item.order_date }}</td>-->
                                <!--<td>{{ item.status }}</td>-->
                            <!--</tr>-->
                            <!--</tbody>-->
                        <!--</table>-->
                    <!--</div>-->



                    <!--<div class="modal-footer">-->
                        <!--<download-excel class="btn btn-success" :data="history" :fields="json_fields" name="OrderList.xls">-->
                            <!--Ներբեռնել Excel-->
                        <!--</download-excel>-->
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">փակել</button>-->
                    <!--</div>-->
                <!--</div>-->

            <!--</div>-->
        <!--</div>-->

        <div class="container">
            <div class="col-xs-12 col-sm-6 no-margin">
                <!--<router-link to="/" exact>logo</router-link>-->
            </div>
            <div class="col-xs-12 col-sm-6 no-margin">
                <ul class="right">
                    <li>
                        <router-link to="/">Գլխավոր</router-link>
                    </li>
                    <li>
                        <router-link to="/history" exact v-if="isLogged" > Իմ պատվերները </router-link>
                        <!--<a v-if="isLogged" data-toggle="modal" data-target="#my-order-modal">Իմ պատվերները</a>-->
                    </li>
                    <li>
                        <router-link to="/login" exact v-if="!isLogged">Մուտք</router-link>
                    </li>
                    <li>
                        <a href="#" @click="logout" v-if="isLogged">Ելք</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
    import {mapGetters} from 'vuex';
    import JsonExcel from 'vue-json-excel'


    export default {
        name: 'Navbar',

        // data() {
        //     return {
        //         history: [],
        //         json_fields: {
        //             'Անուն': 'productName',
        //             'Քանակ': 'count',
        //             'Ստեղծվել է': 'order_date',
        //             'Կարգավիճակ': "status"
        //         },
        //         json_meta: [
        //             [
        //                 {
        //                     'key': 'charset',
        //                     'value': 'utf-8'
        //                 }
        //             ]
        //         ],
        //     }
        // },
        computed: mapGetters([
            'isLogged'
        ]),

        data(){
            return{
                position:[],
                user:[],
            }
        },

        mounted() {




        },
        components: {
            downloadExcel: JsonExcel
        },
        // component(){
        //     return {downloadExcel: JsonExcel}
        // },

        methods: {
            logout() {
                this.$router.go("Login");
                this.$store.dispatch('logout');
            },


        }
    }
</script>