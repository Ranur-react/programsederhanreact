import React, {Component} from 'react';
import {Text, View, TextInput, StyleSheet, Button} from 'react-native';

export default class App extends Component {
	constructor(props) {
		super(props);
		this.state = {
			nim: null,
			nama: null,
			alamat: null,
			nohp: null,
			data: [],
		};
	}
	LoadData = async () => {
		let respond = await fetch(
			'http://192.168.1.3/backendci3/Mahasiswa/GetAll',
			{method: 'GET'},
		).then(r => r.json());
		this.setState({data: respond.length != 0 ? respond : []});
	};
	UNSAFE_componentWillMount() {
		this.LoadData();
	}
	render() {
		return (
			<View style={styles.container}>
				<View style={styles.header}>
					<Text style={styles.h1}>INPUT MAHASISWA</Text>
				</View>
				<View style={styles.row}>
					<View style={styles.card}>
						<View style={styles.forms}>
							<Text>NoBP</Text>
							<TextInput style={styles.input} />
						</View>
						<View style={styles.forms}>
							<Text>Nama</Text>
							<TextInput style={styles.input} />
						</View>
						<View style={styles.forms}>
							<Text>Alamat</Text>
							<TextInput style={styles.input} />
						</View>
						<View style={styles.forms}>
							<Text>No.HP</Text>
							<TextInput style={styles.input} />
						</View>
						<View style={styles.forms}>
							<Button title="Simpan" />
						</View>
					</View>
				</View>
				<View style={styles.header}>
					<Text style={styles.h2}>Mahasiswa Tersimpan </Text>
				</View>
				<View style={[styles.row, {alignItems: 'flex-start'}]}>
					{this.state.data.map((value, key) => {
						console.log('=================key===================');
						console.log(value);
						console.log('====================================');
						return (
							<View
								key={key}
								style={[
									styles.card,
									{alignItems: 'flex-start', width: '100%'},
								]}>
								<Text>
									{key + 1}. ({value.nim}) {value.nama},{value.alamat} , Phone:
									{value.hp}
								</Text>
							</View>
						);
					})}
				</View>
			</View>
		);
	}
}
const styles = StyleSheet.create({
	container: {
		width: '100%',
		// backgroundColor: 'blue',
		padding: 0,
		display: 'flex',
		flexDirection: 'column',
	},
	header: {
		width: '100%',
		display: 'flex',
		flexDirection: 'column',
		alignItems: 'center',
		justifyContent: 'center',
		backgroundColor: '#C2DED1',
		shadowColor: '#000',
		shadowOffset: {
			width: 0,
			height: 3,
		},
		shadowOpacity: 0.29,
		shadowRadius: 4.65,

		elevation: 7,
	},

	h1: {
		fontSize: 24,
		fontWeight: 'bold',
		color: '#2C3333',
	},
	h2: {
		fontSize: 16,
		fontWeight: 'bold',
		color: 'grey',
	},
	row: {
		width: '100%',
		display: 'flex',
		flexDirection: 'column',
		alignItems: 'center',
		justifyContent: 'center',
	},
	card: {
		height: 'auto',
		width: 'auto',
		marginHorizontal: 10,
		marginVertical: 5,
		alignItems: 'flex-end',
		justifyContent: 'center',
		padding: 10,
		backgroundColor: '#E7F6F2',
		display: 'flex',
		shadowColor: '#000',
		shadowOffset: {
			width: 0,
			height: 2,
		},
		shadowOpacity: 0.25,
		shadowRadius: 3.84,

		elevation: 5,
	},
	forms: {
		height: 'auto',
		width: 'auto',
		marginVertical: 5,
		display: 'flex',
		flexDirection: 'row',
		alignItems: 'center',
		justifyContent: 'center',
	},
	input: {
		width: 200,
		height: 30,
		marginHorizontal: 10,

		borderColor: 'grey',
		borderWidth: 1,
		borderRadius: 30,
	},
});
