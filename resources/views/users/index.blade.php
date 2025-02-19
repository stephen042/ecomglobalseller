@extends('layouts.users')

@section('content')
<div class="pagetitle d-flex">
    <h5 class="text-dark mx-2 fw-bold"><i class="bi bi-shop"></i> All Marketplaces </h5>
</div>
<x-error-message />
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between text-dark mt-1 mb-3">
                <div class="p-2 flex-fill text-center">
                    <h4><b>${{format_number_shorthand(auth()->user()->account_bal)}}</b></h4>
                    <small>Balance</small>
                </div>
                <div class="p-2 flex-fill text-center">
                    <h4><b>{{format_number_shorthand(auth()->user()->number_of_sales)}}</b></h4>
                    <small>Sales </small>
                </div>
                {{-- <div class="p-2 flex-fill text-center">
                    <h4><b>{{format_number_shorthand(auth()->user()->total_sales)}}</b></h4>
                    <small>Total Sales </small>
                </div> --}}
                <div class="p-2 flex-fill text-center">
                    <h4><b>{{format_number_shorthand(auth()->user()->total_product)}}</b></h4>
                    <small>Total Products </small>
                </div>
            </div>
            <div class="flex-container-user">
                <div class="flex-item-user">
                    <h6><b>Product</b></h6>
                    <br>
                    <p class="m-0"><b>USD</b></p>
                    <span>Last 30 days</span>
                </div>
                <div class="flex-item-user">
                    <h6><b><i class="bi bi-caret-down-fill me-2"></i> Last 30 Days</b></h6>
                    <br>
                    <p class="m-0 text-success"><b>+{{auth()->user()->last_30_days}} %</b></p>
                    <span>Previous 30 days</span>
                </div>
                <div class="flex-item-user">
                    <h6><b><i class="bi bi-caret-down-fill me-2"></i> </b></h6>
                    <br>
                    <p class="m-0 text-success"><b>+{{auth()->user()->last_year}} %</b></p>
                    <span>Last year</span>
                </div>
            </div>
            <div class="col-12 mt-3 p-3">
                <div class="card bg-transparent">
                    <div class="card-body">
                        {{-- <h5 class="card-title">Monthly Sales Chart</h5> --}}

                        <!-- Bar Chart -->
                        <canvas id="barChart" style="width: 100%; height: auto; max-height: 300px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                // Monthly sales data passed from Laravel
                                let salesData = @json($salesData); // Example: [5000, 7000, 0, 8000, ...]
            
                                // Shortened month labels
                                let monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
                                // Initialize the chart
                                new Chart(document.querySelector('#barChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: monthLabels,
                                        datasets: [{
                                            label: 'Monthly Sales',
                                            data: salesData,
                                            backgroundColor: '#FF9B05',
                                            borderColor: '#0000',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false, // Allow height adjustment
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                min: 0,
                                                max: Math.max(...salesData) + 1000, // Dynamic max value
                                                ticks: {
                                                    callback: function(value) {
                                                        return value >= 1000 ? (value / 1000).toFixed(1) + 'K' : value; // Format large numbers as 'K'
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                        <!-- End Bar Chart -->
                    </div>
                </div>
            </div>

            <style>
                /* Increase chart height for smaller screens */
                @media (max-width: 768px) {
                    #barChart {
                        height: 400px !important;
                    }
                }

                #barChart {
                    height: 400px !important;
                }
            </style>

            <hr>
            <div class="row">
                <div class="card">
                    <div class="row pt-3">
                        <div class="col-md-11 col-11">
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <a href="{{route('add_product')}}">
                                        <li class="list-group-item d-flex flex-row justify-content-between  p-3 rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"><i class="bi bi-tags-fill mx-2"></i> Add a Product
                                            </div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                    {{-- modal --}}
                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#viewSellingApplications">
                                        <li class="list-group-item d-flex flex-row justify-content-between  p-3 rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark" ><i class="bi bi-eye-fill mx-2"></i> View Selling
                                                Applications</div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>

                                    <a href="{{route('catalog')}}">
                                        <li class="list-group-item d-flex flex-row justify-content-between p-3 rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"> <i class="bi bi-bag-check mx-2"></i>Manage
                                                Orders</div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                    <a  href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#manageReturns">
                                        <li class="list-group-item d-flex flex-row justify-content-between p-3 border-none rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"> <i class="bi bi-bag-dash-fill mx-2"></i> Manage
                                                Returns</div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                    <a href="mailto:support@fbabeginners.live">
                                        <li class="list-group-item d-flex flex-row justify-content-between p-3 border-none rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"><i class="bi bi-chat-left-fill mx-2"></i> Manage
                                                Casalogs</div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                    <a href="mailto:support@fbabeginners.live">
                                        <li class="list-group-item d-flex flex-row justify-content-between p-3 border-none rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"><i class="bi bi-cart mx-2"></i> Manage
                                                Catalog</div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                    <a href="{{route('affiliate_marketing')}}">
                                        <li class="list-group-item d-flex flex-row justify-content-between p-3 rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"> <i class="bi bi-shop-window mx-2"></i> Affiliate
                                                Marketing </div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                    {{-- transaction histories --}}
                                    <a href="{{ route('transaction_history')}}">
                                        <li class="list-group-item d-flex flex-row justify-content-between p-3 rounded-1"
                                            style="border-bottom: 1px solid grey">
                                            <div class="text-dark"><i class="bi bi-credit-card mx-2"></i> Payments</div>
                                            <div><i class="bi bi-chevron-right text-dark"></i></div>
                                        </li>
                                    </a>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <livewire:user.fund-modal /> --}}

<div class="modal fade" id="viewSellingApplications" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SELLING APPLICATIONS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Selling Platforms List -->
                <div class="d-flex align-items-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/EBay_logo.svg" alt="eBay"
                        style="width: 40px; height: auto; margin-right: 15px;">
                    <span class="fs-5">eBay</span>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://cdn.worldvectorlogo.com/logos/shopify.svg" alt="Shopify"
                        style="width: 40px; height: auto; margin-right: 15px;">
                    <span class="fs-5">Shopify</span>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://cdn.worldvectorlogo.com/logos/walmart-1.svg" alt="Walmart"
                        style="width: 40px; height: auto; margin-right: 15px;">
                    <span class="fs-5">Walmart</span>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon"
                        style="width: 40px; height: auto; margin-right: 15px;">
                    <span class="fs-5">Amazon</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Vertically centered Modal -->

<div class="modal fade" id="manageReturns" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h3> Returns : {{auth()->user()->returns}}</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Vertically centered Modal -->


<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('copyButton').addEventListener('click', function() {
            var copyText = document.getElementById('copyAddress');

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            document.execCommand("copy");

            // Change button text to "Copied"
            this.textContent = 'Copied';

            // Optional: change the button text back to "Copy" after 3 seconds
            setTimeout(() => {
                this.textContent = 'Copy';
            }, 3000);
        });
    });
</script>

@endsection