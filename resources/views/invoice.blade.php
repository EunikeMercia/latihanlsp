<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        .container {
            width: 300px;
        }
        .header {
            margin: 0;
            text-align: center;
        }
        h2, p {
            margin: 0;
        }
        .flex-container-1 {
            display: flex;
            margin-top: 10px;
        }

        .flex-container-1 > div {
            text-align : left;
        }
        .flex-container-1 .right {
            text-align : right;
            width: 200px;
        }
        .flex-container-1 .left {
            width: 100px;
        }
        .flex-container {
            width: 300px;
            display: flex;
        }

        .flex-container > div {
            -ms-flex: 1;  /* IE 10 */
            flex: 1;
        }
        ul {
            display: contents;
        }
        ul li {
            display: block;
        }
        hr {
            border-style: dashed;
        }
        a {
            text-decoration: none;
            text-align: center;
            padding: 10px;
            background: #00e676;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
        body{
            font-family: 'Poppins';
            font-size: 13px;
        }
    </style>
</head>
<body onload="printout()">
    <div class="container">
        <div class="header" style="margin-bottom: 30px;">
            <h2>Toko Pakcik Ical ヾ(•ω•`)o</h2>
            <small><i> Jl. Mantap Jiwa No. 101, Surabaya, Jawa Timur</i></small>
        </div>
        <hr>
        <div class="flex-container-1">
            <div class="left">
                <ul>
                    <li>No Order</li>
                    <li>Kasir</li>
                    <li>Tanggal</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li> {{ $transaksi->id }} </li>
                    <li> {{ $transaksi->getUser->name }} </li>
                    <li> {{ Date('d-m-Y', strtotime($transaksi->date))}}</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-bottom: 10px; text-align:right;">
            <div style="text-align: left;">Nama Product</div>
            <div>Harga/Qty</div>
            <div>Total</div>  
        </div>
        @foreach($transaksi->getDetail as $item)
        <div class="flex-container" style="text-align: right;">
                <div style="text-align: left;">{{$item->getItem->name}}</div>
                <div>Rp {{ number_format($item->getItem->price, 0, ',', '.') }}/{{$item->qty}}</div>
                <div>Rp {{ number_format($item->subtotal, 0, ',', '.')}}</div>
            </div>
        @endforeach
        <hr>
        <div class="flex-container" style="text-align: right; margin-top: 10px;">
            <div>
                <ul>
                    <li>Grand Total</li>
                    <li>Pembayaran</li>
                    <li>Kembalian</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                   <li>Rp. {{ number_format($transaksi->total, 0, ',', '.') }}</li>
                    <li>Rp. {{ number_format($transaksi->pay_total, 0, ',', '.') }}</li>
                    <li>Rp. {{ number_format($transaksi->pay_total - $transaksi->total, 0, ',', '.') }}</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="header" style="margin-top: 50px;">
            <h3>Terimakasih o(*￣︶￣*)o</h3>
            <p>Silahkan berkunjung kembali 😎👍</p>
            <img src="{{ asset('img/mantap.jpg') }}" alt="job image" width="200px" title="job image">
        </div>
    </div>
</body>
<script>
    t= null;
    function printout() {
        window.print();
        t = setTimeout("self.close()", 1000)
    }

    window.onafterprint = function(e) {
        window.location.href = '{{ route('transaction.index') }}'
    }
</script>
</html>
