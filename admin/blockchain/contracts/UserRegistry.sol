// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract UserRegistry {
    struct User {
        string firstName;
        string surname;
        string email;
        bytes32 passwordHash;
        bool exists;
    }

    mapping(string => User) private users;

    event UserRegistered(string email);
    event UserLoggedIn(string email);

    function registerUser(string memory _firstName, string memory _surname, string memory _email, bytes32 _passwordHash) public {
        require(!users[_email].exists, "User already exists");
        
        users[_email] = User({
            firstName: _firstName,
            surname: _surname,
            email: _email,
            passwordHash: _passwordHash,
            exists: true
        });

        emit UserRegistered(_email);
    }

    function loginUser(string memory _email, bytes32 _passwordHash) public view returns (bool) {
        require(users[_email].exists, "User does not exist");
        return users[_email].passwordHash == _passwordHash;
    }

    function userExists(string memory _email) public view returns (bool) {
        return users[_email].exists;
    }

    function getUserInfo(string memory _email) public view returns (string memory, string memory) {
        require(users[_email].exists, "User does not exist");
        return (users[_email].firstName, users[_email].surname);
    }
}