<?php
require(__DIR__.'/fpdf.php');

// Thay đổi thông tin kết nối tới CSDL phù hợp với hệ thống của bạn
$host = 'localhost';
$user = 'admin';
$pass = 'admin';
$db = 'form2';
// Kết nối tới CSDL
$conn = mysqli_connect($host, $user, $pass, $db);
// Lấy dữ liệu từ bảng trong CSDL
$result = mysqli_query($conn, 'SELECT id, name, des, price, quantity, total FROM form');

// Khởi tạo đối tượng FPDF
$pdf = new FPDF();
$pdf->AddPage();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date('d/m/Y H:i:s A');
$prefix = 'PHIEU-';
$unique_id = uniqid();
$invoice_number = $prefix . $unique_id;
$pdf->SetFont('Arial','B',16);
// Xuất tiêu đề của bảng
$pdf->Cell(30,10,'                                      Phieu Nhap Kho Hang Hoa');$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->Cell(30,10,'Date: '.$date,0,1);
$pdf->Cell(30,10,'So Phieu: '.$invoice_number,0,1);
$pdf->Ln();
$pdf->Cell(10,10,'STT', 1);
$pdf->Cell(55,10,'Ten Hang', 1);
$pdf->Cell(55,10,'Mo Ta', 1);
$pdf->Cell(25,10,'So Luong', 1);
$pdf->Cell(30,10,'Don Gia', 1);
$pdf->Cell(35,10,'Tong Gia', 1);
$pdf->Ln();
// Khởi tạo biến lưu trữ thông tin hàng trước đó
$prev_id = null;
$prev_row = null;

// Khởi tạo biến tính tổng giá trị cột total
$ids = array(); // danh sách các id đã xuất hiện

while ($row = mysqli_fetch_assoc($result)) {
    // Kiểm tra xem id của hàng hiện tại đã xuất hiện trong danh sách hay chưa
    if (in_array($row['id'], $ids)) {
        // Tìm phần tử có cùng id và cộng số lượng và giá trị của hàng hiện tại với phần tử đó
        foreach ($pdf_rows as &$pdf_row) {
            if ($pdf_row['id'] == $row['id']) {
                $pdf_row['quantity'] += $row['quantity'];
                $pdf_row['total'] += $row['total'];
                break;
            }
        }
    } else {
        // Nếu chưa xuất hiện thì thêm id vào danh sách
        $ids[] = $row['id'];
        // Xuất thông tin của hàng trước đó (nếu có)
        if ($prev_row !== null) {
            $pdf_rows[] = $prev_row;
        }
        // Gán giá trị của hàng hiện tại cho hàng trước đó
        $prev_row = $row;
    }
    $prev_id = $row['id'];
}

// Xuất thông tin cho hàng cuối cùng (nếu có)
if ($prev_row !== null) {
    $pdf_rows[] = $prev_row;
}

// Xuất thông tin các hàng
$stt = 1;
$tot = 0;
foreach ($pdf_rows as $pdf_row) {
    $pdf->Cell(10,10,$stt,1);
    $pdf->Cell(55,10,$pdf_row['name'],1);
    $pdf->Cell(55,10,$pdf_row['des'],1);
    $pdf->Cell(25,10,$pdf_row['quantity'],1);
    $pdf->Cell(30,10,$pdf_row['price'],1);
    $pdf->Cell(35,10,$pdf_row['total'],1);
    $pdf->Ln();
    $tot += $pdf_row['total']; // tính toán tổng giá trị của cột total
    $stt++;
}
    
    // Tính toán các giá trị thống kê
    $vat = $tot * 0.1; // tính tiền VAT (thuế giá trị gia tăng)
    $grand_tot = $tot + $vat; // tính tổng tiền thanh toán
    
    // Xuất thông tin thống kê
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Ln();
    $pdf->Cell(180,10,'THONG TIN THANH TOAN',1,1,'C');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100,10,'Tong gia tri',1);
    $pdf->Cell(80,10,number_format($tot).',000 VND',1,1,'R');
    $pdf->Cell(100,10,'VAT (10%)',1);
    $pdf->Cell(80,10,number_format($vat).',000 VND',1,1,'R');
    $pdf->Cell(100,10,'Tong thanh toan',1);
    $pdf->Cell(80,10,number_format($grand_tot).',000 VND',1,1,'R');

$pdf->Ln();
// Ghi file PDF và hiển thị cho người dùng
$pdf->Cell(55,10,'Nguoi Nhap Kho: Nguyen Van A');
$pdf->Ln();
$pdf->Cell(55,10,'Nguoi Xuat Kho: Cong ty TNHH ABC');
$pdf->Output();
?>
