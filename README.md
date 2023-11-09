# EITF06-Web-Security
Course project for EITF06 - Web Security at LTH

## To-do
The implementation part of the project has three phases;
- construction,
- attack,
- functionality peer-review.

---
## Construction phase
- Programming language is PHP.
- PHP sessions must be used in a reasonable way.
- Consider security issues related to PHP, including server and PHP configuration, and protection from attacks.
- Use TLS to secure the connection. The connection should be secure when sending sensitive information to the web server.
- Authenticate the server using a certificate (self-signed is ok).
- Authenticate the user using username and password. Define a reasonable password policy balancing complexity and security. Include explicit support for a password blacklist. User credentials should be stored securely in a database (MySQL or any other), reasonably safe from online brute-force attacks and offline TMTO/Rainbow attacks.

### Web Shop Design
- Choose your own visual design for the web shop.
- Support the following features:
  - New users signing up with a username, password, and home address.
  - Existing users signing in, with the username clearly shown when logged in.
  - Adding items to the shopping cart.
  - Checkout and payment via digital currency using a blockchain (implement yourself or use a library of your choice).
    - Key generation for the wallet must use actual asymmetric cryptography.
    - Include proof-of-work with a correct hash of the block.
    - Add a new block with a transaction to the chain of blocks (no need to implement a consensus algorithm).

### Team Responsibilities
1. Chief Architect:
   - Select and document a suitable architecture for the secure web shop.
2. Developers:
   - Implement the designed architecture, considering all security requirements.
3. Testers:
   - Verify that the required features are fully operational.
   - Maintain a functional database for testing purposes.
4. Security Analyst:
   - Maintain a knowledge base on possible attacks.


### Roles - According to instructions
Ellen - Chief architect
Lisa - Chief security analyst
André - Chief tester

