<table>
    <tr>
        <td colspan="5" style="text-align: center; font-weight: bold; font-size: 18px;">NOTA PENGELUARAN PROYEK (HPP)</td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: center; font-weight: bold; font-size: 14px;">BENGKEL NIZAM ALUMINIUM</td>
    </tr>
    <tr><td colspan="5"></td></tr>
    
    <!-- IDENTITAS PROYEK YANG AKURAT -->
    <tr>
        <td colspan="2" style="font-weight: bold;">Job ID</td>
        <td colspan="3">: JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Nama Pelanggan</td>
        <td colspan="3">: {{ $order->customer->name }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Nama Proyek</td>
        <td colspan="3">: {{ $order->project_name }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Tgl. Pesanan Masuk</td>
        <td colspan="3">: {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Tgl. Cetak Nota</td>
        <td colspan="3">: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <!-- RINCIAN PENGELUARAN -->
    <tr>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f3f4f6;">No.</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f3f4f6;">Tgl. Pengeluaran</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f3f4f6;">Kategori Biaya</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f3f4f6;">Deskripsi Belanja / Upah</th>
        <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f3f4f6;">Nominal (Rp)</th>
    </tr>

    @php 
        $no = 1; 
        $total_nota = 0;
    @endphp
    
    <!-- Melakukan loop HANYA pada pengeluaran milik proyek ini -->
    @foreach($order->costs as $cost)
    <tr>
        <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
        <td style="border: 1px solid #000; text-align: center;">{{ \Carbon\Carbon::parse($cost->cost_date)->format('d/m/Y') }}</td>
        <td style="border: 1px solid #000; text-align: center;">{{ ucfirst($cost->category) }}</td>
        <td style="border: 1px solid #000;">{{ $cost->description }}</td>
        <!-- DI SINI PERUBAHANNYA: Menggunakan number_format untuk merapikan angka -->
        <td style="border: 1px solid #000; text-align: right;">{{ number_format($cost->amount, 0, ',', '.') }}</td>
    </tr>
    @php $total_nota += $cost->amount; @endphp
    @endforeach

    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #000;">TOTAL PENGELUARAN (HPP) PROYEK INI:</td>
        <!-- DI SINI PERUBAHANNYA: Menggunakan number_format untuk Total Akhir -->
        <td style="font-weight: bold; text-align: right; border: 1px solid #000; background-color: #fff9c4;">{{ number_format($total_nota, 0, ',', '.') }}</td>
    </tr>
    
    <tr><td colspan="5"></td></tr>
    <tr>
        <td colspan="5" style="text-align: center; font-style: italic; color: #666666;">
            *Nota digital ini diterbitkan secara otomatis oleh Sistem Manajemen Keuangan Nizam Aluminium dan sah sebagai rincian biaya proyek.*
        </td>
    </tr>
</table>