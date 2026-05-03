<table>
    <tr>
        <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">LAPORAN HPP & LABA RUGI PROYEK</td>
    </tr>
    <tr>
        <td colspan="9" style="text-align: center; font-weight: bold; font-size: 14px;">BENGKEL NIZAM ALUMINIUM</td>
    </tr>
    <tr><td colspan="9"></td></tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Parameter Pencarian</td>
        <td colspan="7">: {{ $filter['pencarian'] }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Filter Status Proyek</td>
        <td colspan="7">: {{ $filter['status'] }}</td>
    </tr>
    <!-- TAMPILAN PERIODE BULAN BARU -->
    <tr>
        <td colspan="2" style="font-weight: bold;">Periode Laporan</td>
        <td colspan="7">: {{ $filter['periode_bulan'] }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Tanggal Dicetak</td>
        <td colspan="7">: {{ $filter['tanggal_cetak'] }}</td>
    </tr>
    <tr><td colspan="9"></td></tr>

    <tr>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">No.</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Job ID</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Nama Pelanggan & Proyek</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Status</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Harga Jual (Rp)</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Bahan Baku (Rp)</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Upah Tukang (Rp)</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Total HPP (Rp)</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Laba Bersih (Rp)</th>
    </tr>

    @php 
        $no = 1; 
        $grand_total_jual = 0;
        $grand_total_hpp = 0;
        $grand_total_laba = 0;
    @endphp
    @foreach($orders as $order)
    <tr>
        <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
        <td style="border: 1px solid #000; text-align: center;">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
        <td style="border: 1px solid #000;">{{ $order->customer->name }} - {{ $order->project_name }}</td>
        <td style="border: 1px solid #000; text-align: center;">{{ ucfirst($order->status) }}</td>
        <td style="border: 1px solid #000; text-align: right;">{{ $order->total_price }}</td>
        <td style="border: 1px solid #000; text-align: right;">{{ $order->material_cost }}</td>
        <td style="border: 1px solid #000; text-align: right;">{{ $order->labor_cost }}</td>
        <td style="border: 1px solid #000; text-align: right; background-color: #fce4ec;">{{ $order->total_cost }}</td>
        <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #e8f5e9;">{{ $order->profit }}</td>
    </tr>
    @php 
        $grand_total_jual += $order->total_price;
        $grand_total_hpp += $order->total_cost;
        $grand_total_laba += $order->profit;
    @endphp
    @endforeach

    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #000;">GRAND TOTAL:</td>
        <td style="font-weight: bold; text-align: right; border: 1px solid #000;">{{ $grand_total_jual }}</td>
        <td colspan="2" style="border: 1px solid #000;"></td>
        <td style="font-weight: bold; text-align: right; border: 1px solid #000; background-color: #f8bbd0;">{{ $grand_total_hpp }}</td>
        <td style="font-weight: bold; text-align: right; border: 1px solid #000; background-color: #c8e6c9;">{{ $grand_total_laba }}</td>
    </tr>
</table>