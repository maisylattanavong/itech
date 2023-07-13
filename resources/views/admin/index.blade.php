@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">@lang('backend.dashboard_page')</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- start post table -->
            <div class="row justify-content-between">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">@lang('backend.total_categories')</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($categories) }} @lang('backend.items')
                                    </h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">@lang('backend.total_post')</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($allposts) }} @lang('backend.items')
                                    </h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="ri-stack-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">@lang('backend.total_users')</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($users) }} @lang('backend.users')</h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">@lang('backend.total_visitors')</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($allVisitors) }} @lang('backend.visitors')</h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="fa fa-users font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->


            <!-- statistic table -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title mb-4 text-primary">@lang('backend.latest_categories')</h4> --}}
                            <h4 class="card-title mb-4">@lang('backend.visitors_statistics')
                            </h4>
                            <div class="table-responsive">
                                <!-- Coutry Chart -->
                                <section class="content" style="margin-left:20px;margin-right:20px;margin-top:50px">
                                    <label for="cars">@lang('backend.select_chart_style')</label>
                                    <select name="chartcountry" onchange="CountryFunction()"
                                        class="btn btn-second dropdown-toggle border border-primary" type="button"
                                        id="chartcountry" style="width:120px">
                                        <option value="pie" selected>@lang('backend.pie')</option>
                                        <option value="column">@lang('backend.column')</option>
                                        <option value="pyramid">@lang('backend.pyramid')</option>
                                        <option value="bar">@lang('backend.bar')</option>
                                    </select>
                                    <div class="product-index"style="margin-top:40px">
                                        <div id="chartCountry" style="height: 370px;width:100%"></div>
                                    </div>
                                </section>
                                <!-- End Coutry Chart -->
                                <hr>
                                <!-- Laos chart -->
                                <section class="content" style="margin-left:20px;margin-right:20px;margin-top:50px">
                                    <label for="cars">@lang('backend.select_chart_style')</label>
                                    <select name="chart" onchange="LaosFunction()"
                                        class="btn btn-second dropdown-toggle border border-primary" type="button"
                                        id="chart" style="width:120px">
                                        <option value="pie">@lang('backend.pie')</option>
                                        <option value="column">@lang('backend.column')</option>
                                        <option value="pyramid" selected>@lang('backend.pyramid')</option>
                                        <option value="bar">@lang('backend.bar')</option>
                                    </select>
                                    <div class="product-index" align="right" style="margin-top:40px">
                                        <div id="chartContainer" style="height: 370px;width:100%"></div>
                                    </div>
                                </section>
                                <!--End Laos chart -->
                                <hr>
                                <!-- Year chart -->
                                <section class="content" style="margin-left:20px;margin-right:20px;margin-top:50px">

                                    <label for="cars">@lang('backend.select_year')</label>
                                    <select name="YearChartSelect" id="YearChartSelect" onchange="selectYear()"
                                        class="btn btn-second dropdown-toggle border border-primary" type="button"
                                        style="width:120px">
                                        @php
                                            $dyear = Illuminate\Support\Carbon::now()->format('Y');
                                        @endphp

                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}"
                                                {{ $year->year == $dyear ? 'selected' : '' }}>
                                                {{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <label id="YearChartContainer">{{ $year->total }} @lang('backend.visitors')</label> --}}


                                    <div class="product-index" style="margin-top:40px">
                                        <div id="YearChartContainer" style="height: 370px;width:100%"></div>
                                    </div>
                                </section>
                                <!--End Year chart -->

                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end statistic table -->


            <!-- start post table -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 text-info">@lang('backend.latest_posts')</h4>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-primary">
                                        <tr class="text-info">
                                            <th>@lang('backend.number')</th>
                                            <th>@lang('backend.post_title')</th>
                                            <th>@lang('backend.category')</th>
                                            <th>@lang('backend.image')</th>
                                            <th>@lang('backend.created_by')</th>
                                            <th>@lang('backend.created_at')</th>
                                            <th>@lang('backend.views')</th>
                                            <th style="width: 120px;">@lang('backend.action')</th>
                                        </tr>
                                    </thead><!-- end thead -->

                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($posts as $post)
                                            <tr class="justify-content-center">
                                                <td>
                                                    <h6 class="mb-0">{{ $i++ }}</h6>
                                                </td>
                                                <td>{{ $post['title'] }}</td>
                                                <td>{{ $post['category']['name'] }}</td>
                                                <td><img src="{{ !empty($post->feature_image && file_exists($post->feature_image))
                                                    ? url($post->feature_image)
                                                    : (!empty(file_exists($post->feature_image))
                                                        ? url('upload/no_image.jpg')
                                                        : url('upload/image_deleted.jpg')) }}"
                                                        style="width: 90px; height: 100%"></td>
                                                <td>{{ $post['user']['name'] }}</td>
                                                <td>{{ $post->created_at }}</td>
                                                <td>{{ $post->views }}
                                                    {{-- <td>{{Carbon\Carbon::parse($post->created_at)->format('h:i:s A \ d-m-Y')}}</td> --}}
                                                <td>
                                                    <a href="{{ route('edit.post', $post->id) }}"
                                                        class="btn btn-info btn-sm" title="Edit Data">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <h4 class="d-flex justify-content-center text-muted">@lang('backend.no_data_available_in_table')
                                                    </h4>
                                                </td>
                                            </tr>

                                    </tbody><!-- end tbody -->
                                    @endforelse

                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end post table -->


            <!-- start category table -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 text-primary">@lang('backend.latest_categories')</h4>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-success">
                                        <tr class="text-info">
                                            <th>@lang('backend.number')</th>
                                            <th>@lang('backend.category_name')</th>
                                            <th>@lang('backend.image')</th>
                                            <th>@lang('backend.created_by')</th>
                                            <th>@lang('backend.created_at')</th>
                                            <th style="width: 120px;">@lang('backend.action')</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($categories as $cat)
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0">{{ $i++ }}</h6>
                                                </td>
                                                @php
                                                    $count_posts = App\Models\Post::where('category_id', $cat->id)->get();
                                                @endphp
                                                <td>
                                                    {{ $cat->name }}
                                                    <h6 class="text-truncate font-size-14 mb-2"
                                                        style="color: rgb(123, 0, 247)">
                                                        ({{ count($count_posts) }}
                                                        {{ count($count_posts) > 1 ? 'posts' : 'post' }})
                                                    </h6>
                                                </td>
                                                <td><img src="{{ !empty($cat->image && file_exists($cat->image))
                                                    ? url($cat->image)
                                                    : (!empty(file_exists($cat->image))
                                                        ? url('upload/no_image.jpg')
                                                        : url('upload/image_deleted.jpg')) }}"
                                                        style="width: 90px; height: 100%"></td>
                                                <td>{{ $cat['user']['name'] }}</td>
                                                <td>{{ $cat->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('view.post.cat', [$cat->name, $cat->id]) }}"
                                                        class="btn btn-success btn-sm" title="View Posts">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <h4 class="d-flex justify-content-center text-muted">@lang('backend.no_data_available_in_table')
                                                    </h4>
                                                </td>
                                            </tr>

                                    </tbody><!-- end tbody -->
                                    @endforelse

                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end category table -->


            <script>
                // Country Chart Function
                function CountryFunction() {
                    var chartType = document.getElementById("chartcountry").value;
                    var chart = new CanvasJS.Chart("chartCountry", {
                        animationEnabled: true,
                        title: {
                            text: "@lang('backend.country_visitors_statistics')",
                             fontSize: 20,
                             fontFamily: "noto sans lao",
                             fontColor: "blue",
                        },
                        data: [{
                            type: chartType,
                            indexLabelFontStyle: "italic",
                            indexLabelFontSize: 14,
                            indexLabelFontFamily: "noto sans lao",

                            yValueFormatString: "#,##0.\"\"",
                            indexLabel: "{label} ({y})",
                            dataPoints: <?php echo json_encode($data_country, JSON_NUMERIC_CHECK); ?>
                        }],
                    });
                    chart.render();
                }

                // Laos Chart Function
                function LaosFunction() {
                    var chartType = document.getElementById("chart").value;
                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        title: {
                            text: "@lang('backend.laos_visitors_statistics')",
                             fontSize: 20,
                             fontFamily: "noto sans lao",
                             fontColor: "blue",
                        },
                        data: [{
                            type: chartType,
                            indexLabelFontStyle: "italic",
                            indexLabelFontSize: 14,
                            indexLabelFontFamily: "noto sans lao",

                            yValueFormatString: "#,##0.\"\"",
                            indexLabel: "@lang('backend.s_visitors') ({y})",
                            dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                        }],
                        axisX:{
                        labelFontStyle: "italic",
                        labelFontSize: 16,
                        },

                    });
                    chart.render();
                }

                // Month Chart Function
                function MonthFunction(data) {
                    var chartType = "column";
                    var chart = new CanvasJS.Chart("YearChartContainer", {
                        animationEnabled: true,
                        title: {
                            text: "@lang('backend.monthly_visitors_statistics')",
                            fontSize: 20,
                            fontFamily: "noto sans lao",
                            fontColor: "blue",
                        },
                        data: [{
                            type: chartType,
                            indexLabelFontStyle: "italic",
                            indexLabelFontSize: 14,
                            indexLabelFontFamily: "noto sans lao",
                            yValueFormatString: "#,##0.\"\"",
                            indexLabel: "({label}) ({y})",
                            // indexLabel: "@lang('backend.s_visitors') ({y})",
                            dataPoints: data,
                        }],
                         axisX:{
                         labelFontStyle: "italic",
                         labelFontSize: 16,
                         },

                    });

                    chart.render();
                }
                window.onload = function() {
                    CountryFunction();
                    LaosFunction();
                    MonthFunction();
                    selectYear();
                }
            </script>
        </div>
    </div>
@endsection
