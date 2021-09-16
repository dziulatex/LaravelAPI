@include('base')
<style>
    #userDiv{width:auto;z-index:999;position:absolute;
        top: 100px;
        left: 250px; border-radius: 25px;
        background: url(https://www.w3schools.com/css/paper.gif);
        background-position: left top;
        background-repeat: repeat;visibility:hidden;}
    .modal-body {
        /* 100% = dialog height, 120px = header + footer */
        max-height: calc(100% - 120px);
        overflow-y: scroll;
    }
    .modal-content {
         /* 80% of window height */
         height: 80%;
     }
    #basicInfoModal{height:40%;width:100%;}
    #additionalInfoModal{height:70%;width:100%;}
    #companyInfoModal{width:100%;}
    .catchPhrase{word-wrap: break-word;}
</style>
<?php



?>
<div class="modal" id="userAdditional" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Full Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div id="basicInfoModal" style="width:100%;">
                   <h6> Basic info:</h6>
                   <ul style="float:left;list-style-type:none;">
                       <li>Name: </li>
                       <li>Username: </li>
                       <li>Email: </li>
                       <li>Phone number:</li>
                   </ul>
                   <ul style="float:left;list-style-type:none;padding-left:15px;">
                       <li class="name"></li>
                       <li class="username"></li>
                       <li class="email"></li>
                       <li class="phone_number"></li>
                   </ul>

               </div>

                <div id="additionalInfoModal">
                    <h6> Additional info:</h6>
                    <ul style="float:left;list-style-type:none;">
                        <li>City: </li>
                        <li>Street: </li>
                        <li>Suite: </li>
                        <li>Zipcode:</li>
                        <li>Latitude: </li>
                        <li>Longtitude:</li>
                        <li>Website:</li>
                    </ul>
                    <ul style="float:left;list-style-type:none;padding-left:15px;">
                        <li class="city"></li>
                        <li class="street"></li>
                        <li class="suite"></li>
                        <li class="zipcode"></li>
                        <li class="latitude"></li>
                        <li class="longtitude"></li>
                        <li class="website"></li>
                    </ul>
                </div>
                <div id="companyInfoModal">
                    <h6> Company info:</h6>
                    <ul style="float:left;list-style-type:none;">
                        <li>Company Name: </li>
                        <li>Catch Phrase: </li>
                        <li>Short(bs): </li>

                    </ul>
                    <ul style="float:left;list-style-type:none;padding-left:15px;">
                        <li class="companyName"></li>
                        <li class="catchPhrase"></li>
                        <li class="short"></li>

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<h1 valign="middle"> All posts of users:</h1>
<table id="posts" class="display">
    <thead>
    <tr>
        <th>User</th>
        <th>Title</th>
        <th>Body</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div id="userDiv" class="animate__animated">
    <ul style="float:left;list-style-type:none;">
        <li>Name: </li>
        <li>Username: </li>
        <li>Email: </li>
        <li>Phone number:</li>
    </ul>
    <ul style="float:left;list-style-type:none;padding-left:15px;">
        <li class="nameModal"></li>
        <li class="usernameModal"></li>
        <li class="emailModal"></li>
        <li class="phone_numberModal"></li>
    </ul>
</div>
<script>
    var user;
    var userBasic;
    axios.post('/getPosts')
        .then(function (response) {
            $('#posts').DataTable({
                pageLength: 50,
                data: response.data,
                columns: [
                    {'data': 'userId'},
                    {'data': 'title'},
                    {'data': 'body'},

                ],
                "columnDefs": [
                    {className: "user", "targets": [0]}
                ]
            });
        })

    $(document).on('mouseenter', 'tbody tr .user', function (event) {
        var pageX=event.pageX;
        var pageY=event.pageY;
        if (user!=$(this).text()) {
            axios
            ({
                method: 'post',
                url: '/getUserBasic',
                data:
                    {
                        id: $(this).text()
                    }
            }).then(function (response) {
                userBasic=response.data;
                $('#userDiv .name').text(response.data.name);
                $('#userDiv .username').text(response.data.username);
                $('#userDiv .email').text(response.data.email);
                $('#userDiv .phone_number').text(response.data.phone_number);
            })
        }
        $('#userDiv').css('top',pageY);
        $('#userDiv').css('left',pageX);
        $('#userDiv').css('visibility','visible');
        $('#userDiv').addClass('animate__rubberBand');
        setTimeout(function(){

            $('#userDiv').removeClass('animate__rubberBand');
        },700);

        user=$(this).text();
    });
    $(document).on('mouseleave', '.user', function (event) {
            $('#userDiv').css('visibility','hidden');

    });
    $(document).on('click', 'tbody tr .user', function (event) {
        $('#userAdditional').modal('show');
        $('#userAdditional .name').text(userBasic.name);
        $('#userAdditional .username').text(userBasic.username);
        $('#userAdditional .email').text(userBasic.email);
        $('#userAdditional .phone_number').text(userBasic.phone_number);
            axios
            ({
                method: 'post',
                url: '/getUserAdditional',
                data:
                    {
                        id: $(this).text()
                    }
            }).then(function (response) {
                $('#additionalInfoModal .city').text(response.data.city);
                $('#additionalInfoModal .street').text(response.data.street);
                $('#additionalInfoModal .suite').text(response.data.suite);
                $('#additionalInfoModal .zipcode').text(response.data.zipcode);
                $('#additionalInfoModal .latitude').text(response.data.latitude);
                $('#additionalInfoModal .longtitude').text(response.data.longtitude);
                $('#additionalInfoModal .website').text(response.data.website);
            })
        axios
        ({
            method: 'post',
            url: '/getUserCompany',
            data:
                {
                    id: $(this).text()
                }
        }).then(function (response) {
            alert(JSON.stringify(response.data));

            $('#companyInfoModal .companyName').text(response.data.companyName);
            $('#companyInfoModal .catchPhrase').text(response.data.catchPhrase);
            $('#companyInfoModal .short').text(response.data.short);

        })

        user=$(this).text();
    });

</script>

