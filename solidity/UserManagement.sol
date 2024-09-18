// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract UserManagement {
    struct User {
        string firstName;
        string surname;
        string sex;
        uint256 dateOfBirth;
        string country;
        string email;
        string cellNumber;
        bytes32 passwordHash;
    }

    mapping(address => User) public users;
    mapping(string => address) private emailToAddress;

    event UserRegistered(address userAddress, string email);
    event UserLoggedIn(address userAddress, string email);

    function register(
        string memory _firstName,
        string memory _surname,
        string memory _sex,
        uint256 _dateOfBirth,
        string memory _country,
        string memory cellNumber,
        string memory _email,
        
        string memory _password
    ) public {
        require(emailToAddress[_email] == address(0), "Email already registered");
        
        bytes32 passwordHash = keccak256(abi.encodePacked(_password));
        
        users[msg.sender] = User(_firstName, _surname, _sex, _dateOfBirth, _country, _email, cellNumber, passwordHash);
        emailToAddress[_email] = msg.sender;
        
        emit UserRegistered(msg.sender, _email);
    }

    function login(string memory _email, string memory _password) public view returns (bool) {
        address userAddress = emailToAddress[_email];
        require(userAddress != address(0), "User not found");
        
        bytes32 passwordHash = keccak256(abi.encodePacked(_password));
        require(users[userAddress].passwordHash == passwordHash, "Incorrect password");
        
        return true;
    }

    function getUserInfo(address _userAddress) public view returns (
        string memory firstName,
        string memory surname,
        string memory sex,
        uint256 dateOfBirth,
        string memory country,
        string memory email,
        string memory cellNumber
    ) {
        User memory user = users[_userAddress];
        return (user.firstName, user.surname, user.sex, user.dateOfBirth, user.country, user.email, user.cellNumber);
    }
}