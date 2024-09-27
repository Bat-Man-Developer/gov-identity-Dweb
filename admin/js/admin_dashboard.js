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
		"inputs": [],
		"name": "getBlockNumber",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
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

const UserRegistryAddress = "0x4d33F8f18e27A2cF4D8F2B8BB5B40809d4e2fE70";

window.addEventListener('load', async () => {
    if (typeof window.ethereum !== 'undefined') {
        try {
            await window.ethereum.request({ method: 'eth_requestAccounts' });
            window.web3 = new Web3(window.ethereum);
            console.log('Web3 initialized successfully');
            initDashboard();
        } catch (error) {
            console.error('Error initializing Web3:', error);
            showError('Failed to connect to Web3. Please make sure MetaMask is installed, connected, and you have approved this site.');
        }
    } else {
        console.log('Web3 not detected');
        showError('Web3 not detected. Please install MetaMask to use this dApp!');
    }
});

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.color = 'red';
    errorDiv.style.textAlign = 'center';
    errorDiv.style.marginTop = '20px';
    document.querySelector('#admin-pages').prepend(errorDiv);
    document.querySelector('#admin-div').style.display = 'none';
}

function getEmailFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('adminEmail');
}

async function initDashboard() {
    const userRegistry = new web3.eth.Contract(UserRegistryABI, UserRegistryAddress);
    
    const email = getEmailFromURL();
    if (!email) {
        showError("Email not provided in URL");
        return;
    }

    try {
        const accounts = await web3.eth.getAccounts();
        const currentAccount = accounts[0];

        // Check if the user exists
        const userExists = await userRegistry.methods.userExists(email).call();
        console.log("User exists:", userExists);

        if (!userExists) {
            showError(`User with email ${email} does not exist`);
            return;
        }

        // If user exists, retrieve user info
        const [firstName, surname] = await userRegistry.methods.getUserInfo(email).call({ from: currentAccount });
        console.log("Retrieved user info:", firstName, surname);

        document.getElementById('admin-info').textContent = `${firstName} ${surname}`;
    } catch (error) {
        console.error("Detailed error:", error);
        let errorMessage = "Failed To Retrieve Admin Data. ";
        if (error.message.includes("execution reverted")) {
            errorMessage += "The transaction was reverted by the smart contract. ";
            if (error.message.includes("caller is not the admin")) {
                errorMessage += "You do not have admin permissions.";
            } else {
                errorMessage += "Please check your permissions and contract state.";
            }
        } else if (error.message.includes("gas")) {
            errorMessage += "Transaction may have run out of gas. Please try again with a higher gas limit.";
        } else {
            errorMessage += "Try Again Or Contact Support Team: " + error.message;
        }
        document.getElementById('webMessageError').textContent = errorMessage;
        document.getElementById('webMessageSuccess').textContent = "";
        document.getElementById('admin-info').textContent = "";
    }
}