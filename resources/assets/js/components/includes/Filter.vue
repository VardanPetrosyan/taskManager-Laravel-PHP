<template>


    <div class="widget">
        <h1>Product Filters</h1>
        <div class="body bordered">

            <div class="category-filter">
                <h2>Categories</h2>
                <hr>
                <ul v-html="categories"></ul>
            </div>

            <div class="price-filter">
                <h2>Price</h2>
                <hr/>
                <div class="price-range-holder">
                    <div class="row">
                        <div class="col-xs-6">
                            <label>min</label>
                            <input v-on:change="minPrice" class="form-control" min="0" type="number">
                        </div>
                        <div class="col-xs-6">
                            <label>min</label>
                            <input v-on:change="maxPrice" class="form-control" min="1" type="number">
                        </div>
                    </div>
                    <div class="row">
                        <button v-on:click="filterFunc" style="margin-top: 20px; width: 100%" class="btn btn-success">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    // import Head from "./includes/Head";
    import $ from "jquery";


    export default {
        name: "",
        categoryFilter: [],
        props:[''],
        data() {
            return {
                categories: [],
                categoryFilter: [],
            }
        },
        components: {
            Head
        },
        mounted() {
            this.getCategories();


        },

        methods: {
            getCategories() {
                let url = "/auth/category";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {category: this.categoryFilter, price: this.priceFilter},
                )
                .then((data) => {

                    // this.categories = data.data;
                    this.categories = this.printcat(data.data);
                    console.log(this.printcat(data.data));
                })
                .catch((e) => {
                    console.log('exception', e);
                });
            },


            printcat(data, deep = 0) {
                this.filterByCategory(12);
                var element = "";

                for (let i = 0; i < data.length; i++) {
                    element =
                        element +
                        "<li>" +
                        "<a style='margin-left: " + deep * 15 + "px; border-bottom: 2px solid' id='cat-" + data[i].id + "' v-bind:onclick='" + this.filterByCategory(data[i].id) + "' href='#'>" + data[i].name + "</a>" +
                        this.printcat(data[i].child.original, ++deep) +
                        "</li>";
                    deep--;
                }

                return element;
            },


            filterByCategory(id) {
                console.log(id);
                let filter = this.categoryFilter;
                if (filter.includes(id)) {
                    filter.splice(filter.indexOf(id), 1);
                    document.getElementById('cat-' + id).style.color = "#59B210";
                } else {
                    filter.push(id);
                    document.getElementById('cat-' + id).style.color = "#c1000e";
                }
                this.categoryFilter = filter;
            },


            //
            // filterFunc() {
            //     alert();
            //     var url = "auth/search";
            //     axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
            //     axios.post(
            //         url,
            //         {search: this.search, category: this.categoryFilter, price: [this.min, this.max]},
            //     )
            //     .then((data) => {
            //
            //     })
            //     .catch((e) => {
            //         console.log(e);
            //     });
            //
            //     console.log(this.categoryFilter, this.min, this.max, this.search);
            // },
            //
            //
            // animation(id = 0) {
            //     var cart = $('#cart');
            //     // var imgtodrag = $('#img-1');
            //     var imgtodrag = $('#asdf');
            //     if (imgtodrag) {
            //         var imgclone = imgtodrag.clone()
            //             .offset({
            //                 top: imgtodrag.offset().top,
            //                 left: imgtodrag.offset().left
            //             })
            //             .css({
            //                 'opacity': '1',
            //                 'position': 'absolute',
            //                 'height': '150px',
            //                 'width': '150px',
            //                 'z-index': '100',
            //                 'border': '1px solid',
            //                 'box-shadow': '0px 0px 10px 5px rgba(2,181,23,0.5)'
            //             })
            //             .appendTo($('body'))
            //             .animate({
            //                 'top': cart.offset().top,
            //                 'left': cart.offset().left + 10,
            //                 'width': 75,
            //                 'height': 75,
            //                 'border-radius': 50 + '%'
            //             }, 600);
            //
            //         setTimeout(function () {
            //             cart.effect("shake", {
            //                 times: 2
            //             }, 200);
            //         }, 15000);
            //
            //         imgclone.animate({
            //             'width': 0,
            //             'height': 0
            //         }, function () {
            //             $(this).detach()
            //         });
            //     }
            // }

        }

    }
</script>

<style scoped>

</style>