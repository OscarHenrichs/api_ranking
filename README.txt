
# API RANKING

Separei o projeto em models, controllers e rotas, além de duas pastas dedicadas à configuração do ambiente e outra para utilitários.
Organizei dessa forma pensando em um projeto que possa escalar e ir para produção sem grandes refatorações.

A query em si era simples, então foquei em construir um router robusto, limitar vulnerabilidades 
e configurar um Docker para facilitar a execução do programa junto aos dados.

Para rodar pode usar o comando 

```bash
sudo docker-compose down -v && docker-compose up -d --build
```

ou 

```bash
sudo php -S 0.0.0.0:5000 src/index.php
```

e chamar usando

```bash
curl -X GET http://localhost:8080/ranking/?movimento_id=1
```

