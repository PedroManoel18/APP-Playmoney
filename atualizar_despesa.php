body{
    background:#f4f6f9;
    font-family:Arial,sans-serif;
}

.navbar{
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.card{
    border:none;
    border-radius:15px;
}

.card-playmoney{
    width:100%;
    max-width:420px;
}

.dashboard-card{
    transition:.3s;
}

.dashboard-card:hover{
    transform:translateY(-5px);
}

.btn{
    border-radius:8px;
}

.table{
    background:white;
}

h1,h2,h3,h4{
    font-weight:600;
}

@media print{
    .navbar,
    .btn{
        display:none!important;
    }

    body{
        background:white;
    }
}
