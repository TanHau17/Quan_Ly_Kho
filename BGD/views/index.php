    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        #myModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        #myModal .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        #closeModal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        #closeModal:hover {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div style="text-align: center; font-size:35px" class="fw-bold">Kế Hoạch Sản Xuất</div>

<button id="openModalBtn" class="btn btn-primary mr-3" style="background-color: ;">Tạo Mới</button>

<div id="myModal">
    <div class="modal-content">
        <span id="closeModal">&times;</span>
        <h3>Form</h3>
        <form id="myForm">
            <label for="data">Data:</label>
            <input type="text" id="data" name="data" required>
            <br>
            <button type="button" onclick="submitForm()">Submit</button>
        </form>
    </div>
</div>

<script>

    var modal = document.getElementById('myModal');


    var btn = document.getElementById('openModalBtn');


    var span = document.getElementById('closeModal');


    btn.onclick = function() {
        modal.style.display = 'block';
    }


    span.onclick = function() {
        modal.style.display = 'none';
    }


    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    function submitForm() {
        var formData = document.getElementById('data').value;   
        console.log('Form data submitted: ' + formData);
        modal.style.display = 'none';
    }
</script>