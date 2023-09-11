@extends('layouts.dashboard.app')

@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Appartment</strong> Dashboard</h3>
            </div>

            <div class="col-auto ms-auto text-end mt-n1">
                <a href="#" class="btn btn-light bg-white me-2">
                    <i class="align-middle me-1" data-feather="refresh-cw"></i> Refresh
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Rent</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">৳47482</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Maintenance</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">৳5660</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Employee Salary</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="activity"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">৳16,300</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Fund</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">৳41520</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="float-end">
                            <form class="row g-2">
                                <div class="col-auto">
                                    <select class="form-select form-select-sm bg-light border-0">
                                        <option>Jan</option>
                                        <option value="1">Feb</option>
                                        <option value="2">Mar</option>
                                        <option value="3">Apr</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control form-control-sm bg-light rounded-2 border-0" style="width: 100px;" placeholder="Search..">
                                </div>
                            </form>
                        </div>
                        <h5 class="card-title mb-0">Total Revenue</h5>
                    </div>
                    <div class="card-body pt-2 pb-3">
                        <div class="chart chart-md">
                            <canvas id="chartjs-dashboard-line"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-end">
                            <div class="dropdown position-relative">
                                <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                    <i class="align-middle" data-feather="more-horizontal"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Sales/Revenue</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradientLight = ctx.createLinearGradient(0, 0, 0, 225);
        gradientLight.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradientLight.addColorStop(1, "rgba(215, 227, 244, 0)");
        var gradientDark = ctx.createLinearGradient(0, 0, 0, 225);
        gradientDark.addColorStop(0, "rgba(51, 66, 84, 1)");
        gradientDark.addColorStop(1, "rgba(51, 66, 84, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line"
            , data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                , datasets: [{
                    label: "Sales (৳)"
                    , fill: true
                    , backgroundColor: window.theme.id === "light" ? gradientLight : gradientDark
                    , borderColor: window.theme.primary
                    , data: [
                        2115
                        , 1562
                        , 1584
                        , 1892
                        , 1587
                        , 1923
                        , 2566
                        , 2448
                        , 2805
                        , 3438
                        , 2917
                        , 3327
                    ]
                }]
            }
            , options: {
                maintainAspectRatio: false
                , legend: {
                    display: false
                }
                , tooltips: {
                    intersect: false
                }
                , hover: {
                    intersect: true
                }
                , plugins: {
                    filler: {
                        propagate: false
                    }
                }
                , scales: {
                    xAxes: [{
                        reverse: true
                        , gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                    , yAxes: [{
                        ticks: {
                            stepSize: 1000
                        }
                        , display: true
                        , borderDash: [3, 3]
                        , gridLines: {
                            color: "rgba(0,0,0,0.0)"
                            , fontColor: "#fff"
                        }
                    }]
                }
            }
        });
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Bar chart
        new Chart(document.getElementById("chartjs-dashboard-bar"), {
            type: "bar"
            , data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                , datasets: [{
                    label: "This year"
                    , backgroundColor: window.theme.primary
                    , borderColor: window.theme.primary
                    , hoverBackgroundColor: window.theme.primary
                    , hoverBorderColor: window.theme.primary
                    , data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79]
                    , barPercentage: .75
                    , categoryPercentage: .5
                }]
            }
            , options: {
                maintainAspectRatio: false
                , legend: {
                    display: false
                }
                , scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                        , stacked: false
                        , ticks: {
                            stepSize: 20
                        }
                    }]
                    , xAxes: [{
                        stacked: false
                        , gridLines: {
                            color: "transparent"
                        }
                    }]
                }
            }
        });
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var markers = [{
                coords: [37.77, -122.41]
                , name: "San Francisco: 375"
            }
            , {
                coords: [40.71, -74.00]
                , name: "New York: 350"
            }
            , {
                coords: [39.09, -94.57]
                , name: "Kansas City: 250"
            }
            , {
                coords: [36.16, -115.13]
                , name: "Las Vegas: 275"
            }
            , {
                coords: [32.77, -96.79]
                , name: "Dallas: 225"
            }
        ];
        var map = new jsVectorMap({
            map: "us_aea_en"
            , selector: "#usa_map"
            , zoomButtons: true
            , markers: markers
            , markerStyle: {
                initial: {
                    r: 9
                    , stroke: window.theme.white
                    , strokeWidth: 7
                    , stokeOpacity: .4
                    , fill: window.theme.primary
                }
                , hover: {
                    fill: window.theme.primary
                    , stroke: window.theme.primary
                }
            }
            , regionStyle: {
                initial: {
                    fill: window.theme["gray-200"]
                }
            }
            , zoomOnScroll: false
        });
        window.addEventListener("resize", () => {
            map.updateSize();
        });
        setTimeout(function() {
            map.updateSize();
        }, 250);
    });

</script>
@endpush
