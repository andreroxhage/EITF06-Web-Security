# EITF06-Web-Security
Course project for EITF06 - Web Security at LTH

## To-do
The implementation part of the project has three phases;
• construction,
• attack,
• functionality peer-review.

---

## Construction phase
• Programming language is PHP.
• PHP sessions must be used in a reasonable way.
• The security issues related to PHP included in the course shall be considered (server and PHP
configuration and protection from attacks).
• TLS will be used to secure the connection. The connection should at least be secure when sending
sensitive information to the web server.
• The server is to be authenticated using a certificate (self-signed is ok).
2
• The user is authenticated using username and password. Define a reasonable password policy that
balances complexity and security. Include explicit support for a password blacklist to exclude the
most common passwords. User credentials are to be stored securely in a database of your choice
(MySQL or any other). The credentials must be reasonably safe from on-line brute-force attacks
and off-line TMTO/Rainbow attacks.
You are free to choose your own (visual) design of the web shop and it can sell anything you choose.
Your application MUST support the following.
• New users signing up. When signing up, users choose a username, password and enter a home
address.
• Existing users signing in. The username must be clearly shown on the page when a user is logged
in.
• Adding items to shopping cart.
• Checkout and payment. The payment should be processed via digital currency utilizing a blockchain
which you can implement yourself or take a library of your choice. Once the payment is finished
the user should be presented with a receipt with all details of the purchase. The following is a list
of requirements for the payment using a blockchain:
– The key generation for the wallet must be real, i.e., use actual asymmetric cryptography, same
for signatures.
– There should be proof-of-work with a correct hash of the block.
– A new block with a transaction should be added to the chain of blocks (you don’t need to
implement a consensus algorithm).
Based on the above requirements, your first step is to have the chief architect being responsible for
the selection and documentation of a suitable architecture for the secure web shop. Then, the developers
takes responsibility for the implementation of the designed architecture, giving careful consideration to
all security requirements. After security features are implemented, testers are responsible for verifying
that the required features are fully operational, and they are also responsible for maintaining a functional
database for testing purposes. The security analyst is responsible for the knowledge base on possible
attacks.
Note here that being responsible does not necessarily mean that you do it without help from the rest,
but rather that you are responsible for it being done. The actual work can be distributed within the
group.
This concludes the constructional phase of you web shop, which should be more or less fully functional,
like a real-world website, except for the payment part.


### Roles - According to instructions
Ellen - Chief architect
Lisa - Chief security analyst
André - Chief tester

