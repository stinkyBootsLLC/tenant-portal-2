# Tenanat Application Issues

As is, the Tenant app is a minimal viable working solution; however, this app was created in the beginning of my sofware development journey and still has some problems, particurlary with security.

## Security Vulnerabilities

### 1. Application is Vulnerable to Brute Force Attacks

This application has no lockout mechanism in place. An attacker could easily automate multiple passwords from a dictionary or other source against a single account. The applications should enforce a limit of [insert number] consecutive invalid logon attempts by a user  and uutomatically lock the account or node for an [insert time]
period. Account lockout mechanisms are used to mitigate brute force password guessing attacks. 

- See NIST Control [AC-7 UNSUCCESSFUL LOGON ATTEMPTS](https://csrc.nist.gov/publications/detail/sp/800-53/rev-5/final)
- See OWASP [Testing for Weak Lock Out Mechanism](https://owasp.org/www-project-web-security-testing-guide/v41/4-Web_Application_Security_Testing/04-Authentication_Testing/03-Testing_for_Weak_Lock_Out_Mechanism)

### 2. Passwords are not salted.

While the passwords in this application build are stored in a secured hash, they should also be salted. Proper password salting will produce two different hashes for the same password. 

> A cryptographic salt is data which is applied during the hashing process in order to eliminate the possibility of the output being looked up in a list of pre-calculated pairs of hashes and their input, known as a rainbow table [PHP FAQ](https://www.php.net/manual/en/faq.passwords.php). 

You basically add the random salt to the end hash. To add a salting mechanism to this application, we can use a combination of [PHP Hash](https://www.php.net/manual/en/function.password-hash.php) and [PHP Verify](https://www.php.net/manual/en/function.password-verify.php) function.

1. When creating and storing the password use `password_hash($password,PASSWORD_DEFAULT, array('cost' => 9))`
2. Use `password_verify('userInputPlainTextPassword', $storedInDBpasswordHash))` verify that the plain text password matches the hash stored in the DB
3. If there is a match, then allow entry.

For example the password "1234" hashed with no salt is `$2y$09$NiO0auNuCbW54B2/1k.VKOqCikVyCc0FHHifESHDRfuKt/JaJNaGa`. But with **salt** the password "1234" is `03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4`

### 3. Application does not have Account Management Features

There is no way to edit user profiles.

### 4. Application does not log events

> Returning to the OWASP Top 10 2021, this category is to help detect, escalate, and respond to active breaches. Without logging and monitoring, breaches cannot be detected. Insufficient logging, detection, monitoring, and active response occurs any time. [(A09:2021)](https://owasp.org/Top10/A09_2021-Security_Logging_and_Monitoring_Failures/)

See NIST [AU-2 EVENT LOGGING](https://csrc.nist.gov/Projects/risk-management/sp800-53-controls/release-search#/control?version=5.1&number=AU-2)


### 5. Application Should Have Multi-Factor Authentication Control Mechanism

While there is a second secret question asked after a successful login, a two-Factor Authentication (2FA) control mechanism would improve the overall security posture.

> Multi-Factor authentication (MFA), or Two-Factor Authentication (2FA) is when a user is required to present more than one type of evidence in order to authenticate on a system. [(Multi-Factor Authentication Cheat Sheet)](https://cheatsheetseries.owasp.org/cheatsheets/Multifactor_Authentication_Cheat_Sheet.html)

See NIST [IA-2 IDENTIFICATION AND AUTHENTICATION (ORGANIZATIONAL USERS)](https://csrc.nist.gov/Projects/risk-management/sp800-53-controls/release-search#/control?version=5.1&number=IA-2)









