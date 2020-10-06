# Arquitetura utilizada

- Docker, rodando imagens Nginx, PHP FPM, MySQL e Redis
- Todos os registros são sincronizados com o Redis, para um melhor desempenho.

# Como rodar
Você pode rodar o comando `make prepare`, que vai construir todas as imagens do Docker, rodar o composer e rodar as migrações. Em caso de erro, rode um `docker system prune -a `. Nota, isso vai apagar todas as imagens e containers da sua máquina.

Depois disso, você pode rodar `make up` e testar os endpoints ou rodar os testes.


Para adicionar um novo registro
```
POST http://localhost:8000/api/user_location
{
	"user_id": 3,
	"latitude": -23.5136716,
	"longitude": -46.6264793
}
```


Para ler um registro:
```
GET http://localhost:8000/api/user_location/{id}
```


Para rodar os testes, basta executar `make test`.
