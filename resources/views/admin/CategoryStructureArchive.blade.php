@extends('_layouts.admin')
@section('content')
    <style>
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(18px);
            -ms-transform: translateX(18px);
            transform: translateX(18px);
        }

        #example_filter > label > input {
            position: relative;
            top: 6px;
        }

        #example_wrapper > .row:nth-child(3) {
            width: 100% !important;
        }

        #example_wrapper > .row:nth-child(2) > .col-sm-12 {
            padding-left: 0 !important;
        }

        .line {
            border: 1px solid lightgrey;
            width: 400px;
            margin: 20px 0;
        }

        li {
            text-decoration: none;
            font-weight: bold;
        }


    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Վերականգնել բաժին</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <form method="post" action="{{ route('admin_categories_structure_update_archive') }}"
                                      style="width: 100%">
                                    @csrf
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label for="category">Բաժին</label>
                                            <select name="mainCategoryUpdate" id="category" class="form-control h-75">
                                                <option value="" selected hidden></option>
                                                @foreach($categories as $categorie)
                                                    <option value="{{$categorie->id }}">{{ $categorie->category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        @if($errors->has('mainCategoryUpdate'))
                                            <p class="alert alert-danger p-3">
                                                {{ $errors->first('mainCategoryUpdate') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="form-group ">
                                        <hr/>
                                        <input type="submit" value="Հաստատել" class="btn btn-success float-right">
                                    </div>

                                </form>


                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
@stop
@section('script')

    <script type="text/javascript">
        // function demo_rename() {
        //     var ref = $('#jstree_demo').jstree(true),
        //         sel = ref.get_selected();
        //     if(!sel.length) { return false; }
        //     sel = sel[0];
        //     ref.edit(sel);
        //     console.log(sel);
        // };
        // function demo_delete() {
        //     var ref = $('#jstree_demo').jstree(true),
        //         sel = ref.get_selected();
        //     if(!sel.length) { return false; }
        //     ref.delete_node(sel);
        //     console.log(sel);
        // };
        //
        // $('#jstree_demo').jstree({
        //     "core": {
        //         "animation": 0,
        //         "check_callback": true,
        //         "themes": {"apple": true},
        //         'data': {
        //             'url': '/admin/selectCategoryView',
        //             'data': function (node) {
        //                 return {'id': node.id};
        //             }
        //         }
        //     },
        //     "types": {
        //         "#": {
        //             "max_children": 1,
        //             "max_depth": 4,
        //             "valid_children": ["root"]
        //         },
        //         "root": {
        //             "icon": "/static/3.3.9/assets/images/tree_icon.png",
        //             "valid_children": ["default"]
        //         },
        //         "default": {
        //             "valid_children": ["default", "file"]
        //         },
        //         "file": {
        //             "icon": "glyphicon glyphicon-file",
        //             "valid_children": []
        //         }
        //     },
        //
        //
        //     // 'checkbox': {
        //     //     'three_state': false,
        //     //     "tie_selection":false,
        //     //     'whole_node':false
        //     // },
        //
        //     "plugins": [
        //          "contextmenu", "search",
        //         "state", "types", "wholerow"
        //     ]
        // });
        //

        // $(function () {
        //
        //
        //     $('#SimpleJSTree').jstree({
        //         "core": {
        //             "check_callback": true,
        //             'data': {
        //                 'url': '/admin/selectCategoryView'
        //             }
        //
        //         },
        //         "plugins": ["contextmenu"],
        //
        //         "contextmenu": {
        //             "items": function ($node) {
        //                 var tree = $("#SimpleJSTree").jstree(true);
        //
        //                 return {
        //                     "Rename": {
        //                         "separator_before": false,
        //                         "separator_after": false,
        //                         "label": "Փախել անունը",
        //                         "action": function (data) {
        //
        //                             tree.edit($node);
        //                             let changeId = $node.id;
        //                             let changeText = $node.text;
        //
        //                             $(document).on('change', '.jstree-rename-input', function () {
        //                                 changeText = event.target.value;
        //                                 $.post('/admin/selectCategoryRename/' + changeId + '/' + changeText, function (data) {
        //                                 })
        //
        //                             });
        //                         }
        //                     },
        //                     "Remove": {
        //                         "separator_before": false,
        //                         "separator_after": false,
        //                         "label": "Ջնջել",
        //                         "action": function (obj) {
        //                             tree.delete_node($node);
        //                             let changeId = $node.id;
        //                             $.post('/admin/selectCategoryDelete/' + changeId, function (data) {
        //                             })
        //
        //                         }
        //                     }
        //                 };
        //             }
        //         }
        //     });
        //
        //
        // });


    </script>
@stop
