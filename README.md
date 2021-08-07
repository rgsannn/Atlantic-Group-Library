# Atlantic-Group-Library

PHP Library To Interact With All APIs From https://atlantic-group.co.id/

Full Documentation, Please Visit :
- Game Validation : https://atlantic-group.co.id/api/v1/docs/game-validation
- WhatsApp        : https://atlantic-group.co.id/api/v1/docs/whatsapp
- Mutation        : https://atlantic-group.co.id/api/v1/docs/mutation

### Intalasi
Untuk Dapat Menggunakan Fungsi Ini, Pertama-tama Upload Script Atl-Group.php Ke Web Anda Dan Buat Api Key Di [Atlantic Group](https://atlantic-group.co.id/) Lalu Copy Api Id, Api Key Dan Subscription Id Jika Berlangganan Mutasi Atau Whatsapp. Lalu Buat Kodingan Berikut Di File Anda Lalu Pastekan Data Api Id, Api Key Dan Subscription Id Pada Kodingan Berikut :
```
require 'Atl-Group.php'; // Arahkan Ke File Atl-Group.php Sesuai Anda Menyimpannya

$AtlGroup = new AtlGroup(
    [
        'api_id' => '', // YOUR API ID
        'api_key' => '', // YOUR API KEY
        'subs_id' => [
            'whatsapp' => '', // YOUR SUBSCRIPTION ID WHATSAPP (OPTIONAL)
            'mutasi' => '' // YOUR SUBSCRIPTION ID MUTASI (OPTIONAL)
        ]
    ]
);
```
Silahkan Cek File [example-usage.php](example-usage.php) Untuk Lebih Detailnya

### Game Validation
ID Only :
- Arena of Valor
- Call of Duty Mobile
- Chessrush
- Dragon Raja
- Free Fire
- Hago
- Laplace M
- Light of Thel
- Lords Mobile
- Point Blank
- Ragnarok
- Speed Drifters
- Valorant

ID & Zone :
- Crisis Action
- Life After
- Mobile Legends

Format Penulisan :
```
$AtlGroup->GameValidator('Name Game', 'Player ID', 'Zone/Server Id Jika Ada');
```
Example With Zone :
```
$AtlGroup->GameValidator('Mobile Legends', '50366399', '2004');
```
Example Without Zone :
```
$AtlGroup->GameValidator('Free Fire', '123456789');
```

### Whatsapp
Untuk Webhook Bisa Cek Disini [AtlanticHook.php](https://github.com/ShennBoku/AtlanticWhatsApp/blob/master/AtlanticHook.php)
- #### Push Message
  Untuk Mengirim Push Message Bisa Memanggil Function Seperti Dibawah Ini
  
  Format Penulisan :
```
// Kirim Pesan
$AtlGroup->Whatsapp('send-message', ['WHATSAPP NUMBER OR ID/NAME GROUP', 'MESSAGE']);

// Kirim File
$AtlGroup->Whatsapp('send-file', ['WHATSAPP NUMBER OR ID/NAME GROUP', 'MIME', 'SOURCE', 'MESSAGE']);

// Kirim Lokasi
$AtlGroup->Whatsapp('send-location', ['WHATSAPP NUMBER OR ID/NAME GROUP', 'LATITUDE', 'LONGTITUDE', 'MESSAGE']);

// Contoh Kirim Pesan
$AtlGroup->Whatsapp('send-message', [081210110328, 'Punten Mamanx!']);
```
  Contoh MIME: application/pdf | image/jpg | image/png | video/mp4
- #### Add / Remove Group Participant
  Untuk Add Atau Remove Member Grup Bisa Memanggil Function Seperti Dibawah Ini
```
// Add Member To Group
$AtlGroup->Whatsapp('add-user', ['ID/NAME GROUP', 'MESSAGE', 'WHATSAPP NUMBER TO ADD']);

// Remove Member In Group
$AtlGroup->Whatsapp('remove-user', ['ID/NAME GROUP', 'MESSAGE', 'WHATSAPP NUMBER TO REMOVE']);
```
- #### Update Grup
  Untuk Update Grup Bisa Memanggil Function Seperti Dibawah Ini
```
// Ubah Nama Group
$AtlGroup->Whatsapp('update-group-name', ['ID/NAME GROUP', 'SUBJECT']);

// Ubah Deskripsi Group
$AtlGroup->Whatsapp('update-group-desc', ['ID/NAME GROUP', 'DESCRIPTION']);
```
### Mutasi
- #### Info
  Untuk Menampilkan Informasi Nama, Nomor Rekening, Saldo Bahkan Point Bisa Memanggil Function Seperti Dibawah Ini
```
// Menampilkan Semua Informasi
$AtlGroup->Mutasi('info');

// Menampilkan BCA Saja
$AtlGroup->Mutasi('info', 'BCA');
```
- #### Mutasi Bank
  Untuk Menampilkan Mutasi Bank Bisa Memanggil Function Seperti Dibawah Ini
```
$AtlGroup->Mutasi('BCA', ['FROM DATE', 'TO DATE', 'QUANTITY', 'DESCRIPTION']);
$AtlGroup->Mutasi('BNI', ['FROM DATE', 'TO DATE', 'QUANTITY', 'DESCRIPTION']);
```
- #### Mutasi Emoney
  Untuk Menampilkan Mutasi Emoney Bisa Memanggil Function Seperti Dibawah Ini
```
$AtlGroup->Mutasi('GOPAY', [10, 'QUANTITY', 'DESCRIPTION']);
$AtlGroup->Mutasi('OVO', [10, 'QUANTITY', 'DESCRIPTION']);
```

Jika Ingin Menampilkan Semua Mutasi Tanpa Limit, Quantity Atau Deskripsi Bisa Menuliskan Dengan Cara Ini :
```
$AtlGroup->Mutasi('PROVIDER');

// Example
$AtlGroup->Mutasi('OVO');
```

## Authors
* **Dhifo Aksa Hermawan** - *BOT Developer* - [Dhifo](https://www.facebook.com/dhifoaksa)
* **Afdhalul Ichsan Yourdan** - *BOT Documentation* - [ShennBoku](https://facebook.com/ShennBoku)
* **Rifqi Galih Nur Ikhsan** - *This Library* - [RGSann](https://facebook.com/rgsann)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
