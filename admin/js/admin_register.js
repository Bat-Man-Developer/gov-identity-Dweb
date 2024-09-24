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

window.addEventListener('load', async () => {
    if (typeof window.ethereum !== 'undefined') {
        try {
            // Request account access
            await window.ethereum.request({ method: 'eth_requestAccounts' });
            window.web3 = new Web3(window.ethereum);
        } catch (error) {
            console.error("User denied account access");
        }
    } else {
        alert('No web3? You should consider using MetaMask!');
        window.web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
    }

    const userRegistry = new web3.eth.Contract(UserRegistryABI, UserRegistryAddress);
    
    document.getElementById('reg-form').addEventListener('submit', async (e) => {
        e.preventDefault();
    
        const firstName = document.getElementById('adminFirstName').value;
        const surname = document.getElementById('adminSurname').value;
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;
        const rePassword = document.getElementById('adminRePassword').value;
    
        if (password !== rePassword) {
            document.getElementById('webMessageError').textContent = "Passwords do not match";
            document.getElementById('webMessageSuccess').textContent = "";
            return;
        }
    
        const passwordHash = web3.utils.sha3(password);
    
        try {
            const accounts = await web3.eth.getAccounts();
            
            // Check if user already exists
            const userExists = await userRegistry.methods.userExists(email).call();
            
            if (userExists) {
                document.getElementById('webMessageError').textContent = "User with this email already exists";
                document.getElementById('webMessageSuccess').textContent = "";
                return;
            }
            
            // If user doesn't exist, proceed with registration
            const gas = await userRegistry.methods.registerUser(firstName, surname, email, passwordHash).estimateGas({from: accounts[0]});
            const result = await userRegistry.methods.registerUser(firstName, surname, email, passwordHash).send({ from: accounts[0], gas: gas });
            
            console.log("Transaction result:", result);
            
            window.location.href = "admin_login.php?success=" + encodeURIComponent("Admin Registered Successfully. Login to proceed.");
        } catch (error) {
            console.error("Registration error:", error);
            let errorMessage = "Failed To Register Admin. ";
            if (error.message.includes("User already exists")) {
                errorMessage += "This email is already registered.";
            } else if (error.message.includes("gas")) {
                errorMessage += "Transaction may have run out of gas. Please try again with a higher gas limit.";
            } else {
                errorMessage += "Try Again Or Contact Support Team: " + error.message;
            }
            document.getElementById('webMessageError').textContent = errorMessage;
            document.getElementById('webMessageSuccess').textContent = "";
        }
    });
});