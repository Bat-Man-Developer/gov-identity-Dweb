const UserRegistryABI = [
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "string",
				"name": "email",
				"type": "string"
			}
		],
		"name": "UserLoggedIn",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "string",
				"name": "email",
				"type": "string"
			}
		],
		"name": "UserRegistered",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "_email",
				"type": "string"
			}
		],
		"name": "getUserInfo",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "_email",
				"type": "string"
			},
			{
				"internalType": "bytes32",
				"name": "_passwordHash",
				"type": "bytes32"
			}
		],
		"name": "loginUser",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "_firstName",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "_surname",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "_email",
				"type": "string"
			},
			{
				"internalType": "bytes32",
				"name": "_passwordHash",
				"type": "bytes32"
			}
		],
		"name": "registerUser",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "_email",
				"type": "string"
			}
		],
		"name": "userExists",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "view",
		"type": "function"
	}
];

const UserRegistryAddress = "0x0E01863877C33a6AA27C03C007EB4ba59820959a";

function getEmailFromURL() {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get('adminEmail');
}

async function initWeb3() {
	if (typeof window.ethereum !== 'undefined') {
		try {
			// Request account access
			await window.ethereum.request({ method: 'eth_requestAccounts' });
			window.web3 = new Web3(window.ethereum);
		} catch (error) {
			console.error("User denied account access");
			return null;
		}
	} else {
		window.web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
		window.location.href = "admin_login.php";
	}
	return window.web3;
}

async function getUserInfo() {
	const web3 = await initWeb3();
	if (!web3) return;

	const userRegistry = new web3.eth.Contract(UserRegistryABI, UserRegistryAddress);
	
	const email = getEmailFromURL();
	if (!email) {
		console.error("Email not provided in URL");
		return;
	}

	try {
		const accounts = await web3.eth.getAccounts();

		// Retrieve and display user info
		const [firstName, surname] = await userRegistry.methods.getUserInfo(email).call({ from: accounts[0] });
		
		const adminInfoElement = document.getElementById('admin-info');
		if (adminInfoElement) {
			adminInfoElement.innerHTML = `
				<p>${firstName} </p>
				<p>${surname}</p>
			`;
		} else {
			console.error("Admin info element not found");
		}
	} catch (error) {
		console.error("Retrieve Error:", error);
		let errorMessage = "Failed To Retrieve Admin Data. ";
		errorMessage += "Try Again Or Contact Support Team: " + error.message;
		
		const errorElement = document.getElementById('webMessageError');
		if (errorElement) {
			errorElement.textContent = errorMessage;
		}
		
		const successElement = document.getElementById('webMessageSuccess');
		if (successElement) {
			successElement.textContent = "";
		}
		
		const adminInfoElement = document.getElementById('admin-info');
		if (adminInfoElement) {
			adminInfoElement.textContent = "";
		}
	}
}

window.addEventListener('load', getUserInfo);