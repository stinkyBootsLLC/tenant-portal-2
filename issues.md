# Tenanat Application Issues

As is, the Tenant app is a minimal viable working solution; however, this app was created in the beginning of my sofware development journey and still has some problems, particurlary with security.

## Security Vulnerabilities

### Application is Vulnerable to Brute Force Attacks

This application has no lockout mechanism in place. An attacker could easily automate multiple passwords from a dictionary or other source against a single account. The applications should enforce a limit of [insert number] consecutive invalid logon attempts by a user  and uutomatically lock the account or node for an [insert time]
period. Account lockout mechanisms are used to mitigate brute force password guessing attacks. 

- See NIST Control [AC-7 UNSUCCESSFUL LOGON ATTEMPTS](https://csrc.nist.gov/publications/detail/sp/800-53/rev-5/final)
- See OWASP [Testing for Weak Lock Out Mechanism](https://owasp.org/www-project-web-security-testing-guide/v41/4-Web_Application_Security_Testing/04-Authentication_Testing/03-Testing_for_Weak_Lock_Out_Mechanism)

### Passwords are not salted.

While the passwords in this application build are stored in a secured hash, they should also be salted. Proper password salting will produce two different hashes for the same password. 

> A cryptographic salt is data which is applied during the hashing process in order to eliminate the possibility of the output being looked up in a list of pre-calculated pairs of hashes and their input, known as a rainbow table [PHP FAQ](https://www.php.net/manual/en/faq.passwords.php). 

You basically add the random salt to the end hash. To add a salting mechanism to this application, we can use a combination of [PHP Hash](https://www.php.net/manual/en/function.password-hash.php) and [PHP Verify](https://www.php.net/manual/en/function.password-verify.php) function.

1. When creating and storing the password use `password_hash($password,PASSWORD_DEFAULT, array('cost' => 9))`
2. Use `password_verify('userInputPlainTextPassword', $storedInDBpasswordHash))` verify that the plain text password matches the hash stored in the DB
3. If there is a match, then allow entry.

For example the password "1234" hashed with no salt is `$2y$09$NiO0auNuCbW54B2/1k.VKOqCikVyCc0FHHifESHDRfuKt/JaJNaGa`. But with **salt** the password "1234" is `03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4`
