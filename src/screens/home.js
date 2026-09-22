

import React, { useEffect, useState, useRef } from 'react'
import {
	View,
	Text,
	StyleSheet,
	FlatList,
	Modal,
	TextInput,
	TouchableOpacity,
	Alert,
	SafeAreaView,
	ScrollView,
	Dimensions,
} from 'react-native'
import AsyncStorage from '@react-native-async-storage/async-storage'

const STORAGE_KEY = 'sesi_horarios_salas'

const DADOS_PADRAO = {
	'1A': { intervalos: [{ inicio: '09:30', fim: '10:00' }, { inicio: '15:20', fim: '15:50' }] },
	'1B': { intervalos: [{ inicio: '09:30', fim: '10:00' }, { inicio: '15:20', fim: '15:50' }] },
	'2A': { intervalos: [{ inicio: '09:45', fim: '10:15' }, { inicio: '15:35', fim: '16:05' }] },
	'2B': { intervalos: [{ inicio: '09:45', fim: '10:15' }, { inicio: '15:35', fim: '16:05' }] },
	'3A': { intervalos: [{ inicio: '10:00', fim: '10:30' }, { inicio: '15:50', fim: '16:20' }] },
	'3B': { intervalos: [{ inicio: '10:00', fim: '10:30' }, { inicio: '15:50', fim: '16:20' }] },
}

function paraMinutos(hora) {
	const partes = hora.split(':')
	return parseInt(partes[0], 10) * 60 + parseInt(partes[1], 10)
}

function formatarHora(date) {
	const h = String(date.getHours()).padStart(2, '0')
	const m = String(date.getMinutes()).padStart(2, '0')
	const s = String(date.getSeconds()).padStart(2, '0')
	return `${h}:${m}:${s}`
}

export default function Home() {
	const [horariosSalas, setHorariosSalas] = useState({})
	const [now, setNow] = useState(new Date())
	const [modalVisible, setModalVisible] = useState(false)
	const [name, setName] = useState('')
	const [inicio, setInicio] = useState('09:30')
	const [fim, setFim] = useState('10:00')
	const [toast, setToast] = useState({ msg: '', tipo: '', vis: false })
	const intervalRef = useRef(null)

	useEffect(() => {
		loadData()
		intervalRef.current = setInterval(() => setNow(new Date()), 1000)
		return () => clearInterval(intervalRef.current)
	}, [])

	async function loadData() {
		try {
			const raw = await AsyncStorage.getItem(STORAGE_KEY)
			if (raw) {
				setHorariosSalas(JSON.parse(raw))
			} else {
				await AsyncStorage.setItem(STORAGE_KEY, JSON.stringify(DADOS_PADRAO))
				setHorariosSalas(DADOS_PADRAO)
			}
		} catch (e) {
			setHorariosSalas(DADOS_PADRAO)
		}
	}

	async function salvarDados(novo) {
		setHorariosSalas(novo)
		try {
			await AsyncStorage.setItem(STORAGE_KEY, JSON.stringify(novo))
		} catch (e) {
			// ignore
		}
	}

	function getSalasOrdenadas(obj) {
		return Object.keys(obj).sort((a, b) => {
			const numA = parseInt(a, 10)
			const numB = parseInt(b, 10)
			if (!isNaN(numA) && !isNaN(numB)) return numA - numB
			if (!isNaN(numA)) return -1
			if (!isNaN(numB)) return 1
			return a.localeCompare(b)
		})
	}

	function salaEmIntervalo(sala, horaAtual) {
		const horarios = horariosSalas[sala]
		if (!horarios) return false
		for (let i = 0; i < horarios.intervalos.length; i++) {
			const inicioM = paraMinutos(horarios.intervalos[i].inicio)
			const fimM = paraMinutos(horarios.intervalos[i].fim)
			if (horaAtual >= inicioM && horaAtual <= fimM) return true
		}
		return false
	}

	function proximoHorarioSala(sala, horaAtual) {
		const horarios = horariosSalas[sala]
		if (!horarios) return null
		let proximo = null
		let menorDiff = Infinity
		for (let i = 0; i < horarios.intervalos.length; i++) {
			const inicio = paraMinutos(horarios.intervalos[i].inicio)
			if (horaAtual < inicio) {
				const diff = inicio - horaAtual
				if (diff < menorDiff) {
					menorDiff = diff
					proximo = horarios.intervalos[i]
				}
			}
		}
		if (!proximo && horarios.intervalos.length > 0) return horarios.intervalos[0]
		return proximo
	}

	function showToast(msg, tipo = 'sucesso') {
		setToast({ msg, tipo, vis: true })
		setTimeout(() => setToast({ msg: '', tipo: '', vis: false }), 3000)
	}

	function adicionarSala() {
		const nome = name.trim()
		if (!nome) return showToast('Digite o nome da sala!', 'erro')
		if (!inicio || !fim) return showToast('Selecione os horários!', 'erro')
		if (horariosSalas[nome]) return showToast(`A sala "${nome}" já existe!`, 'erro')
		const novo = { ...horariosSalas, [nome]: { intervalos: [{ inicio, fim }] } }
		salvarDados(novo)
		setName('')
		setInicio('09:30')
		setFim('10:00')
		setModalVisible(false)
		showToast(`Sala "${nome}" adicionada!`, 'sucesso')
	}

	function removerSala(sala) {
		Alert.alert('Remover sala', `Remover "${sala}"?`, [
			{ text: 'Cancelar', style: 'cancel' },
			{
				text: 'Remover',
				style: 'destructive',
				onPress: () => {
					const novo = { ...horariosSalas }
					delete novo[sala]
					salvarDados(novo)
					showToast(`Sala "${sala}" removida.`, 'info')
				},
			},
		])
	}

	const largura = Dimensions.get('window').width
	const numColumns = largura > 600 ? 4 : largura > 420 ? 3 : 2
	const salas = getSalasOrdenadas(horariosSalas)
	const agora = now
	const horaAtual = agora.getHours() * 60 + agora.getMinutes()

	function renderCard({ item: sala }) {
		const emIntervalo = salaEmIntervalo(sala, horaAtual)
		const prox = proximoHorarioSala(sala, horaAtual)
		let horarioTexto = '—'
		if (emIntervalo) {
			const horarios = horariosSalas[sala]
			for (let i = 0; i < horarios.intervalos.length; i++) {
				const inicio = paraMinutos(horarios.intervalos[i].inicio)
				const fim = paraMinutos(horarios.intervalos[i].fim)
				if (horaAtual >= inicio && horaAtual <= fim) {
					horarioTexto = `Volta às ${horarios.intervalos[i].fim}`
					break
				}
			}
		} else if (prox) horarioTexto = `Próx: ${prox.inicio}`

		return (
			<View style={styles.card}>
				<Text style={styles.salaNome}>{sala}</Text>
				<View style={styles.ledWrap}>
					<View style={[styles.led, emIntervalo ? styles.ledVerdeRing : styles.ledVermelhoRing]}>
						<View style={styles.ledInner}>
							<View style={[styles.ledDot, emIntervalo ? styles.ledInnerVerde : styles.ledInnerVermelho]} />
						</View>
					</View>
				</View>
				<Text style={[styles.salaStatus, emIntervalo ? styles.textVerde : styles.textVermelho]}>
					{emIntervalo ? 'EM INTERVALO' : 'EM AULA'}
				</Text>
				<Text style={styles.salaHorario}>{horarioTexto}</Text>
				<TouchableOpacity onPress={() => removerSala(sala)} style={styles.btnDanger}>
					<Text style={styles.btnText}>Remover</Text>
				</TouchableOpacity>
			</View>
		)
	}

	return (
		<SafeAreaView style={styles.screen}>
			<View style={styles.pageShell}>
				<View style={styles.headerBar}>
					<View style={styles.logoRow}>
						<View style={styles.icone}><Text style={styles.iconeText}>SESI</Text></View>
						<View>
							<Text style={styles.title}>SESI <Text style={styles.titleAccent}>Painel de Controle</Text></Text>
							<Text style={styles.subtitle}>Monitoramento de intervalos por sala</Text>
						</View>
					</View>
					<View style={styles.headerActions}>
						<View style={styles.clockBadge}><Text style={styles.clockText}>{formatarHora(agora)}</Text></View>
						<TouchableOpacity style={styles.btnAdmin} onPress={() => setModalVisible(true)}>
							<Text style={styles.btnAdminText}>Administrar Salas</Text>
						</TouchableOpacity>
					</View>
				</View>

				<View style={styles.statusBox}>
					<View style={styles.statusLine}>
						<View style={[styles.statusDot, styles.dotGreen]} />
						<Text style={styles.statusText}>Intervalo — Sala liberada</Text>
					</View>
					<View style={styles.statusLine}>
						<View style={[styles.statusDot, styles.dotRed]} />
						<Text style={styles.statusText}>Em aula — Sala fechada</Text>
					</View>
					<Text style={styles.muted}>Atualização automática a cada 1s</Text>
					<Text style={styles.count}>{salas.filter(s => salaEmIntervalo(s, horaAtual)).length} abertas · {salas.length - salas.filter(s => salaEmIntervalo(s, horaAtual)).length} fechadas · {salas.length} salas</Text>
				</View>

				<FlatList
					data={salas}
					keyExtractor={(item) => item}
					renderItem={renderCard}
					numColumns={numColumns}
					contentContainerStyle={styles.grid}
					columnWrapperStyle={styles.row}
					showsVerticalScrollIndicator={false}
				/>
			</View>

			<Modal visible={modalVisible} animationType="slide" transparent>
				<View style={styles.modalOverlay}>
					<View style={styles.modal}>
						<Text style={styles.modalTitle}>Administrar Salas</Text>
						<TextInput placeholder="Nome da Sala" value={name} onChangeText={setName} style={styles.input} />
						<TextInput placeholder="Início (HH:MM)" value={inicio} onChangeText={setInicio} style={styles.input} />
						<TextInput placeholder="Fim (HH:MM)" value={fim} onChangeText={setFim} style={styles.input} />
						<View style={styles.modalActions}>
							<TouchableOpacity style={styles.btnPrimary} onPress={adicionarSala}><Text style={styles.btnText}>Adicionar</Text></TouchableOpacity>
							<TouchableOpacity style={styles.btnSecondary} onPress={() => setModalVisible(false)}><Text style={styles.btnTextSecondary}>Fechar</Text></TouchableOpacity>
						</View>

						<ScrollView style={styles.adminList}>
							{salas.length === 0 && <Text style={styles.muted}>Nenhuma sala cadastrada.</Text>}
							{salas.map((sala) => (
								<View key={sala} style={styles.itemAdmin}>
									<Text style={styles.nomeSala}>{sala}</Text>
									<TouchableOpacity style={styles.btnDangerSmall} onPress={() => removerSala(sala)}>
										<Text style={styles.btnText}>🗑️</Text>
									</TouchableOpacity>
								</View>
							))}
						</ScrollView>
					</View>
				</View>
			</Modal>

			{toast.vis && (
				<View style={[styles.toast, toast.tipo === 'erro' ? styles.toastErro : toast.tipo === 'info' ? styles.toastInfo : styles.toastSucesso]}>
					<Text style={styles.toastText}>{toast.msg}</Text>
				</View>
			)}
		</SafeAreaView>
	)
}

const styles = StyleSheet.create({
	screen: {
		flex: 1,
		backgroundColor: '#dfe3e8',
	},
	pageShell: {
		flex: 1,
		padding: 14,
	},
	headerBar: {
		backgroundColor: '#f4f5f5',
		borderRadius: 12,
		padding: 12,
		flexDirection: 'row',
		justifyContent: 'space-between',
		alignItems: 'center',
		marginBottom: 12,
		borderWidth: 1,
		borderColor: '#d9dde1',
	},
	logoRow: {
		flexDirection: 'row',
		alignItems: 'center',
		flex: 1,
	},
	icone: {
		width: 54,
		height: 54,
		borderRadius: 10,
		backgroundColor: '#d92d4b',
		alignItems: 'center',
		justifyContent: 'center',
		marginRight: 12,
	},
	iconeText: {
		color: '#fff',
		fontWeight: '800',
		fontSize: 16,
	},
	title: {
		color: '#d92d4b',
		fontSize: 17,
		fontWeight: '800',
	},
	titleAccent: {
		color: '#1f1f1f',
	},
	subtitle: {
		color: '#6d7178',
		fontSize: 11,
		marginTop: 2,
	},
	headerActions: {
		flexDirection: 'row',
		alignItems: 'center',
	},
	clockBadge: {
		backgroundColor: '#f5f5f5',
		borderRadius: 20,
		paddingHorizontal: 12,
		paddingVertical: 8,
		marginRight: 10,
		borderWidth: 1,
		borderColor: '#dadfe3',
	},
	clockText: {
		color: '#1f1f1f',
		fontWeight: '700',
		fontSize: 12,
	},
	btnAdmin: {
		backgroundColor: '#d92d4b',
		paddingHorizontal: 14,
		paddingVertical: 10,
		borderRadius: 10,
	},
	btnAdminText: {
		color: '#fff',
		fontWeight: '800',
		fontSize: 12,
	},
	statusBox: {
		backgroundColor: '#f3f4f5',
		borderRadius: 12,
		paddingVertical: 12,
		paddingHorizontal: 14,
		marginBottom: 14,
		borderWidth: 1,
		borderColor: '#dfe3e8',
		flexDirection: 'row',
		flexWrap: 'wrap',
		alignItems: 'center',
	},
	statusLine: {
		flexDirection: 'row',
		alignItems: 'center',
		marginRight: 18,
		marginBottom: 4,
	},
	statusDot: {
		width: 12,
		height: 12,
		borderRadius: 6,
		marginRight: 8,
	},
	dotGreen: { backgroundColor: '#2cbb64' },
	dotRed: { backgroundColor: '#d92d4b' },
	statusText: {
		color: '#1f2937',
		fontSize: 13,
		fontWeight: '600',
	},
	muted: {
		color: '#7c8188',
		fontSize: 12,
		marginLeft: 10,
		marginRight: 14,
	},
	count: {
		fontWeight: '700',
		fontSize: 12,
		color: '#1f2937',
		marginLeft: 6,
	},
	grid: {
		paddingBottom: 24,
	},
	row: {
		justifyContent: 'space-between',
		marginBottom: 12,
	},
	card: {
		backgroundColor: '#f5f6f7',
		borderRadius: 14,
		paddingVertical: 16,
		paddingHorizontal: 10,
		alignItems: 'center',
		marginHorizontal: 3,
		borderWidth: 1,
		borderColor: '#dfe3e8',
		flex: 1,
		minHeight: 170,
	},
	salaNome: {
		fontWeight: '800',
		fontSize: 18,
		color: '#1a1a1a',
		marginBottom: 10,
	},
	ledWrap: {
		marginVertical: 8,
	},
	led: {
		width: 70,
		height: 70,
		borderRadius: 35,
		alignItems: 'center',
		justifyContent: 'center',
	},
	ledVerdeRing: {
		backgroundColor: 'rgba(44, 187, 100, 0.12)',
		borderWidth: 2,
		borderColor: '#2cbb64',
	},
	ledVermelhoRing: {
		backgroundColor: 'rgba(217, 45, 75, 0.12)',
		borderWidth: 2,
		borderColor: '#d92d4b',
	},
	ledInner: {
		width: 52,
		height: 52,
		borderRadius: 26,
		backgroundColor: '#fff',
		alignItems: 'center',
		justifyContent: 'center',
	},
	ledDot: {
		width: 30,
		height: 30,
		borderRadius: 15,
	},
	ledInnerVerde: { backgroundColor: '#2cbb64' },
	ledInnerVermelho: { backgroundColor: '#d92d4b' },
	salaStatus: {
		fontSize: 12,
		fontWeight: '800',
		marginTop: 8,
		letterSpacing: 0.4,
	},
	textVerde: { color: '#2cbb64' },
	textVermelho: { color: '#d92d4b' },
	salaHorario: {
		color: '#6b7280',
		fontSize: 12,
		marginTop: 6,
		marginBottom: 10,
		textAlign: 'center',
	},
	btnDanger: {
		backgroundColor: '#d92d4b',
		paddingHorizontal: 16,
		paddingVertical: 8,
		borderRadius: 10,
		alignItems: 'center',
		justifyContent: 'center',
		width: '100%',
	},
	btnDangerSmall: {
		backgroundColor: '#d92d4b',
		padding: 7,
		borderRadius: 8,
	},
	btnPrimary: {
		backgroundColor: '#d92d4b',
		paddingHorizontal: 16,
		paddingVertical: 10,
		borderRadius: 10,
		marginRight: 8,
	},
	btnSecondary: {
		backgroundColor: '#e5e7eb',
		paddingHorizontal: 16,
		paddingVertical: 10,
		borderRadius: 10,
	},
	btnText: {
		color: '#fff',
		fontWeight: '800',
	},
	btnTextSecondary: {
		color: '#1f2937',
		fontWeight: '700',
	},
	modalOverlay: {
		flex: 1,
		backgroundColor: 'rgba(0,0,0,0.55)',
		justifyContent: 'center',
		padding: 18,
	},
	modal: {
		backgroundColor: '#fff',
		borderRadius: 16,
		padding: 16,
		maxHeight: '85%',
	},
	modalTitle: {
		fontSize: 19,
		fontWeight: '800',
		marginBottom: 12,
		color: '#171b22',
	},
	input: {
		backgroundColor: '#f7f8fa',
		padding: 10,
		borderRadius: 10,
		marginBottom: 8,
		borderWidth: 1,
		borderColor: '#e5e7eb',
	},
	modalActions: {
		flexDirection: 'row',
		justifyContent: 'flex-end',
		marginBottom: 12,
	},
	adminList: { maxHeight: 220 },
	itemAdmin: {
		flexDirection: 'row',
		justifyContent: 'space-between',
		alignItems: 'center',
		padding: 10,
		borderRadius: 10,
		backgroundColor: '#f4f5f7',
		marginBottom: 8,
	},
	nomeSala: { fontWeight: '700', color: '#1f2937' },
	toast: {
		position: 'absolute',
		bottom: 20,
		left: 20,
		right: 20,
		padding: 12,
		borderRadius: 10,
		alignItems: 'center',
	},
	toastText: { color: '#fff', fontWeight: '700' },
	toastSucesso: { backgroundColor: '#2cbb64' },
	toastErro: { backgroundColor: '#d92d4b' },
	toastInfo: { backgroundColor: '#3b82f6' },
})