@extends('canvas')
@section('title', 'My Offers')
@section('title_header', 'Listing my offers on Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')
    <div id="addOffer" class="normal-btn addOfferButton">
        Add an offer
    </div>
    @if (Session::has('success'))
        <div class="alert success">{{Session::get('success')}}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert error">{{Session::get('error')}}</div>
    @endif
    <form autocomplete="off" id="offers" action="{{route('offers.store')}}" method="POST">
        @CSRF
        <input id="name" type="text" placeholder="Name" name="name" required>
        <input id="amount" type="text" placeholder="Amount" name="amount" required>
        <input id="price" type="number" placeholder="Price" name="price" required>
        <input type="datetime-local" name="timeleft" required id="myDate" value="2022-08-14 05:55">
        <div class="autocomplete">
            <input id="adresse" type="text" placeholder="Address" name="address" required>
        </div>
        <button id="buttonAdd" class="btn-submit">Add an offer</button>
    </form>

    <table id="offers_list">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Expiration Date</th>
            <th>Expiration Hours</th>
            <th>Offer address</th>
            <th>Action</th>
        </tr>
        @foreach($offers as $count=> $offer)
            <tr data-idOffre="{{$offer->id}}" data-title="{{$offer->title}}" data-quantity="{{$offer->quantity}}"
                data-price="{{$offer->price}}" data-expDate="{{$offer->expirationDate}}"
                data-address="{{$offer->address}}">
                <td>{{$offer->title}}</td>
                <td>{{$offer->quantity}}</td>
                <td>{{$offer->price}} €</td>

                <?php
                $given_date = new DateTime($offer->expirationDate);

                $now_midnight = new DateTime('today midnight');
                $now_end = (new DateTime('today midnight'))->modify("+23 hours")->modify("+59 minutes");
                $tomorrow_midnight = new DateTime('tomorrow midnight');
                $tomorrow_end = (new DateTime('tomorrow midnight'))->modify("+23 hours")->modify("+59 minutes");
                $after_tomorrow_midnight = (new DateTime('tomorrow midnight'))->modify("+1 day");
                $after_tomorrow_end = (new DateTime('tomorrow midnight'))
                    ->modify("+1 day")->modify("+23 hours")->modify("+59 minutes");

                if ($given_date >= $now_midnight && $given_date <= $now_end) {
                    $formatted_date = "Today";
                    $formatted_hours = date_format($given_date, 'G:i');
                } else if ($given_date >= $tomorrow_midnight && $given_date <= $tomorrow_end) {
                    $formatted_date = "Tomorrow";
                    $formatted_hours = date_format($given_date, 'G:i');
                } else if ($given_date >= $after_tomorrow_midnight && $given_date <= $after_tomorrow_end) {
                    $formatted_date = "After tomorrow";
                    $formatted_hours = date_format($given_date, 'G:i');
                } else {
                    $formatted_date = date_format($given_date, 'Y-m-d');
                    $formatted_hours = date_format($given_date, 'G:i');
                }
                ?>
                <td>{{$formatted_date}}</td>
                <td>{{$formatted_hours}}</td>
                <td>{{$offer->address}}</td>
                <td id="buttons">
                    @if(\App\Models\Purchase::where('offer_id',$offer->id)->exists())
                        <span><strong>SOLD</strong></span>
                    @else
                        <form action="{{route("offers.destroy",$offer)}}" method="POST">
                            @CSRF
                            @method('DELETE')
                            <button id="deleteOffer" class="btn btn-red">Delete</button>
                        </form>
                        <button onclick="btnClick($(this))" class="btn btn-orange">Modify</button>
                    @endif

                </td>
            </tr>
        @endforeach
    </table>
@endsection()

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(window).on('load', function () {
            $("#addOffer").on('click', function () {
                $("#offers").show(200)
                $("#addOffer").hide()
            })
        })
        document.getElementById("myDate").min = new Date().getFullYear() + "-" + parseInt(new Date().getMonth() + 1) + "-" +
            new Date().getDate()
    </script>

    <script>
        function btnClick(btn) {
            $("#offers").show(200)
            $("#addOffer").hide()
            $("#buttonAdd").text("Update offer")
            let tr = (btn.parent().parent())

            $("#name").val(tr.attr("data-title"))
            $("#amount").val(tr.attr("data-quantity"))
            $("#price").val(tr.attr("data-price"))
            $("#myDate").val(tr.attr("data-expDate").slice(0, -3).replace(" ", "T"))
            $("#adresse").val(tr.attr("data-address"))
            $("#offers").attr("action", "/offers/" + tr.attr("data-idOffre"))
            $("#offers").append('<input type="hidden" name=id" value="' + tr.attr("data-idOffre") + '">')
            $("#offers").append('<input type="hidden" name="_method" value="PUT">')
        }
    </script>
    <script>
        let countries = [];
        $.get("/myAdresses", function (data) {
            data.forEach(unitAdress => {
                countries.push(unitAdress.address_string);
            })
        });
        /*  @source code : https://www.w3schools.com/howto/howto_js_autocomplete.asp */

    </script>
    <script>
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function (e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function (e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function (e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }

            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        /*  @source code : https://www.w3schools.com/howto/howto_js_autocomplete.asp */

    </script>
    <script>
        autocomplete(document.getElementById("adresse"), countries);
    </script>
@endsection
