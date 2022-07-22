### TUTORIAL REACT NATIVE SEDERHANA

1. #### Clone template backend dari repository dengan perintah dibawah

```
git clone https://github.com/Ranur-react/programsederhanreact.git
```

2. #### Atau dapat mendownload dari repository dengan klik download zip pada url dibawah:

	<https://github.com/Ranur-react/programsederhanreact>

	 ![alt text](./img/Screen%20Shot%202022-07-21%20at%2011.26.08.png)

3. #### Pastikan File template backend ini berada didalam folder "Xampp > hhtdoc ".

 	![alt text](./img/Screen%20Shot%202022-07-21%20at%2011.31.01.png)
 
4. #### Buka Visual Studio Code lalu Klik _Toolsbar->File->Open Folder_

	![alt text](./img/Screen%20Shot%202022-07-21%20at%2011.38.23.png)

5. #### Lalu pilih folder httdoc dan folder backend template tadi yang telah kita tambahkan di dalam httdoc.

 	![alt text](./img/Screen%20Shot%202022-07-21%20at%2011.40.20.png)

6. #### Konfigurasi nama database yang akan kita gunakan di Aplication>Config>database.php

	![alt text](./img/Screen%20Shot%202022-07-21%20at%2011.48.21.png)



7. #### Jangan lupa untuk membuat database atau memastikan database tersebut sudah ada pada SQL

	 ![alt text](./img/Screen%20Shot%202022-07-21%20at%2014.05.52.png)

8. #### lalu buatlah tabel pada database tersebut sesua case yang anda kerjakan ex: tb_karyawan

	 ![alt text](./img/Screen%20Shot%202022-07-21%20at%2014.09.15.png)
9. #### Setelah tabel dibuat jangan lupa attribut/field nya juga disertakan sesuai case dengan memerhatikan typedata nya 
	 ![alt text](./img/Screen%20Shot%202022-07-21%20at%2021.05.53.png)

10. #### Membuat Model pada backend ci3 sesuai dengan tabel yang kita miliki.
 	![alt text](./img/Screen%20Shot%202022-07-21%20at%2015.11.38.png)
 	![alt text](./img/Screen%20Shot%202022-07-21%20at%2015.14.29.png)

11. #### Membuat Controller Tampil data dan simpan data untuk API Aplikasi.

 	![alt text](./img/Screen%20Shot%202022-07-21%20at%2016.57.10.png)


12. #### Membuat Design Front-End CRUD dengan React Native.

	1) Membuat Project React Native baru dengan perintah berikut pada terminal di lokasi folder tujuan:
		````
		npx react-native init namaprj
		````
	2) Tunggu proses pembuatan project hingga muncul notive seperti berikut:
		
		![alt text](./img/Screen%20Shot%202022-07-21%20at%2017.12.59.png)
		ketik 'y' untuk melanjutkan.

	3) Lalu tunggu hingga selesai,

	  ![alt text](./img/Screen%20Shot%202022-07-21%20at%2017.14.59.png)


	4) Jika proses instalasi sudah selesai silahkan jalankan emulator Android pada Android Studio atau langsung menggunakan real devices juga diperkenankan , lalu ketik perintah 'adb devices' untuk memastikan perangkat sudah tersambung dengn  laptop.

	   ![alt text](./img/Screen%20Shot%202022-07-21%20at%2017.31.49.png)

	5) Selanjutnya jika devices sudah muncul dibawah _List of devices_ sekarang teman-teman bisa menjalankan perintah dibawah di folder project react native baru tersebut untuk dapat diajalankan di perangkat.

		masuk kedalam folder project dengan perintah berikut:

		```
		cd namafolderprj
		```

	    ![alt text](./img/Screen%20Shot%202022-07-21%20at%2017.50.10.png)

		lalu jalankan perintah berikut didalam fodler untuk menjalankan
		
		```
		npx react native run-android
		```

    	 ![alt text](./img/Screen%20Shot%202022-07-21%20at%2017.50.10.png)

		sehingga aplikasi dari project baru ini akan muncul diperangkatkat seperti dibawah:

	      ![alt text](./img/Screen%20Shot%202022-07-21%20at%2018.16.15.png)

	6) Selanjutnya pada file app.js di project rubah semua script bawan lalu ganti dengan kodingan sederhana seprti berikut:

       ![alt text](./img/Screen%20Shot%202022-07-21%20at%2018.29.17.png)

	7) Buatlah script desaign form inputan sederhana seperti berikut pada files App.js:
       
	   ![alt text](./img/Screen%20Shot%202022-07-21%20at%2020.26.11.png)

	sehingga tampillnya akan terlihat seperti dibawah jika sudah sekesai

   	 ![alt text](./img/Screen%20Shot%202022-07-21%20at%2020.27.09.png)

 	8) Selanjutnya kita bisa konfigurasi agar desaign ini bisa terhubung dengan dengan API dengan cara berikut:
	 	* Chek API (Tampildata) / backend yang sudah dibiuat dengan postman 

    	![alt text](./img/Screen%20Shot%202022-07-21%20at%2021.16.13.png)
		
		* Implementasikan API tampildata di Design react native dengan script berikut. 
			1. Tulis script dibawah pada bagian atas render() untuk memanggil semua data :

			```
				ambildata async = () => {
					await fetch("http://192.168.1.3/programsederhanreact/Karyawan/GetAll", {
					method:'GET'
					}).then(e => e.json()).then(e => {
						this.setState({data:e})
					})
				}
				UNSAFE_componentWillMount() {
					//panggil method
					this.ambildata();
				}
			```

			Maka akan terlihat seperti berikut:
		     ![alt text](./img/Screen%20Shot%202022-07-21%20at%2022.10.59.png)

		* buatlah function untuk mengolah data yang didaptkan sehingga dapat muncul di tampilan berupa teks biasa dengan script berikut.

		```
			const Tampilkdata = () => {
				if (this.state.data.length != 0) {
					return (
					<View>
						{this.state.data.map((val, key) => {
						return (
							<View key={key}>
							<Text>
							{key + 1}. {val.nama}, {val.alamat}
							</Text>
							</View>
						);
						})}
					</View>
					);
				} else {
					return (
					<View>
						<Text>Empty</Text>
					</View>
					);
				}
			};
		```

  		* Tambahkan Script deklarasi state di constructor untuk data hook  berikut di dalam class default app sebelum render functions.

		  ```
			constructor(props) {
				super(props);
				this.state = {
					data: [],
				};
			}
		  ```
      * Panggil  funtions Tampildata tersebut di dalam script JSX seperti berikut.

     	![alt text](./img/Screen%20Shot%202022-07-22%20at%2014.45.50.png)

	  * Sehingga keslurhan script akan terlihat seperti berikut

     	 ![alt text](./img/Screen%20Shot%202022-07-22%20at%2014.56.02.png)


	* Maka semua data akan tampil seperti berikut:

       ![alt text](./img/Screen%20Shot%202022-07-22%20at%2014.57.17.png)

	* Sekarang lanjutkan dengan membuat method untuk mengirim data yang di input untuk dapat tersimpan lewat API.
	* Tulislah script dibawah di dalam clas

		```
			simpandata = async () => {
				await fetch('http://192.168.1.3/programsederhanreact/Karyawan/GetAll', {
					method: 'GET',
					headers: {
						Accept: 'application/json',
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(this.state.input),
				});
			};
		```	 	

	* Lalu tambahkan obcjet berikut di dalam state constructor

	```
		constructor(props) {
		super(props);
		this.state = {
			data: [],
			input: {},  //objetc ini akan menampung semua inputan
		};
		}
	``` 

	* setalah object dibuat konfigurasi semua event input seperti berikut

	```
		return (
		<View style={styles.container}>
			<TextInput
			style={styles.input}
			onChangeText={e => {
			this.setState({
			input: {
				...this.state.input,
				id: e,
			},
			});
			}}
			placeholder="Masukan ID Karyawan"
			/>
			<TextInput
			style={styles.input}
			onChangeText={e => {
			this.setState({
			input: {
				...this.state.input,
				nama: e,
			},
			});
			}}
			placeholder="Masukan Nama Karyawan"
			/>
			<TextInput
			style={styles.input}
			onChangeText={e => {
			this.setState({
			input: {
				...this.state.input,
				almat: e,
			},
			});
			}}
			placeholder="Masukan Alamat"
			/>
			<Button onPress={this.simpandata} title="SIMPAN" />
			<Text>Data karyawan:</Text>
			<Tampilkdata />
		</View>
		);
	```

 * selanjutkan cobakan input data lalu klik tombol simpan

