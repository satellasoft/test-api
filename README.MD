# Run PHP project

This project was created using PHP **7.4.27** version.

To execute this project, running PHP Server, like a:

```bash
php -S localhost:8000
```

When server is running, then put address bellow into browser:

**https://localhost:8000**


You need execute composer command to generate all autoload file, like at PSR-4 and FILES.

```bash
composer dump-autoload
```

# Test

This project was hosted in https://teste.gunnarcorrea.com.

All test in **IPKISS** pass: 

![Alt text](resources/test.jpeg?raw=true "Title")

https://ipkiss.pragmazero.com/test?url=http%3A%2F%2Fteste.gunnarcorrea.com&script=--%0D%0A%23+Reset+state+before+starting+tests%0D%0A%0D%0APOST+%2Freset%0D%0A%0D%0A200+OK%0D%0A%0D%0A%0D%0A--%0D%0A%23+Get+balance+for+non-existing+account%0D%0A%0D%0AGET+%2Fbalance%3Faccount_id%3D1234%0D%0A%0D%0A404+0%0D%0A%0D%0A%0D%0A--%0D%0A%23+Create+account+with+initial+balance%0D%0A%0D%0APOST+%2Fevent+%7B"type"%3A"deposit"%2C+"destination"%3A"100"%2C+"amount"%3A10%7D%0D%0A%0D%0A201+%7B"destination"%3A+%7B"id"%3A"100"%2C+"balance"%3A10%7D%7D%0D%0A%0D%0A%0D%0A--%0D%0A%23+Deposit+into+existing+account%0D%0A%0D%0APOST+%2Fevent+%7B"type"%3A"deposit"%2C+"destination"%3A"100"%2C+"amount"%3A10%7D%0D%0A%0D%0A201+%7B"destination"%3A+%7B"id"%3A"100"%2C+"balance"%3A20%7D%7D%0D%0A%0D%0A%0D%0A--%0D%0A%23+Get+balance+for+existing+account%0D%0A%0D%0AGET+%2Fbalance%3Faccount_id%3D100%0D%0A%0D%0A200+20%0D%0A%0D%0A--%0D%0A%23+Withdraw+from+non-existing+account%0D%0A%0D%0APOST+%2Fevent+%7B"type"%3A"withdraw"%2C+"origin"%3A"200"%2C+"amount"%3A10%7D%0D%0A%0D%0A404+0%0D%0A%0D%0A--%0D%0A%23+Withdraw+from+existing+account%0D%0A%0D%0APOST+%2Fevent+%7B"type"%3A"withdraw"%2C+"origin"%3A"100"%2C+"amount"%3A5%7D%0D%0A%0D%0A201+%7B"origin"%3A+%7B"id"%3A"100"%2C+"balance"%3A15%7D%7D%0D%0A%0D%0A--%0D%0A%23+Transfer+from+existing+account%0D%0A%0D%0APOST+%2Fevent+%7B"type"%3A"transfer"%2C+"origin"%3A"100"%2C+"amount"%3A15%2C+"destination"%3A"300"%7D%0D%0A%0D%0A201+%7B"origin"%3A+%7B"id"%3A"100"%2C+"balance"%3A0%7D%2C+"destination"%3A+%7B"id"%3A"300"%2C+"balance"%3A15%7D%7D%0D%0A%0D%0A--%0D%0A%23+Transfer+from+non-existing+account%0D%0A%0D%0APOST+%2Fevent+%7B"type"%3A"transfer"%2C+"origin"%3A"200"%2C+"amount"%3A15%2C+"destination"%3A"300"%7D%0D%0A%0D%0A404+0%0D%0A%0D%0A

# Test

```mermaid
  graph TD;
      A-->B;
      A-->C;
      B-->D;
      C-->D;
```