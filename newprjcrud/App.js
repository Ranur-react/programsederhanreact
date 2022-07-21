import React, {Component} from 'react';
import {Text, View, StyleSheet, TextInput, Button} from 'react-native';

export default class App extends Component {
	render() {
		return (
			<View style={styles.container}>
				<TextInput style={styles.input} placeholder="Masukan ID Karyawan" />
				<TextInput style={styles.input} placeholder="Masukan Nama Karyawan" />
				<TextInput style={styles.input} placeholder="Masukan Alamat" />
				<Button title="SIMPAN" />
			</View>
		);
	}
}
const styles = StyleSheet.create({
	container: {
		display: 'flex',
		flexDirection: 'column',
		padding: 10,
	},

	input: {
		borderWidth: 1,
		borderColor: 'black',
	},
});
