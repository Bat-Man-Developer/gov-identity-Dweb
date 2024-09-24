const UserRegistryABI = [
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
    }
];

const UserRegistryAddress = "0x112Ad33090237c06ccebEE70d64fC5477f58f5d6";

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
        console.log('No web3? You should consider using MetaMask!');
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
            return;
        }

        const passwordHash = web3.utils.sha3(password);

        try {
            const accounts = await web3.eth.getAccounts();
            await userRegistry.methods.registerUser(firstName, surname, email, passwordHash).send({ from: accounts[0] });
            window.location.href = "admin_login.php?success=" + encodeURIComponent("Admin Registered Successfully. Login to proceed.");
        } catch (error) {
            document.getElementById('webMessageError').textContent = "Failed To Register Admin. Try Again Or Contact Support Team: " + error.message;
            document.getElementById('webMessageSuccess').textContent = "";
        }
    });
});