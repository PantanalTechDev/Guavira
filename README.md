## Como seu colega pode pegar o repositório na máquina local e criar um fork:

**Criando um fork do repositório:**

1. **Acesse o repositório no GitHub:** Vá para o repositório do GitHub ([https://www.github.com/PantanalTechDev/Guavira.git](https://www.github.com/PantanalTechDev/Guavira.git)).
2. **Clique em "Fork" no canto superior direito.** Isso criará uma cópia do repositório na sua conta.

**Clonando o repositório forkeado:**

1. **Na sua máquina local, navegue até o diretório onde deseja armazenar o repositório clonado.**
2. **Use o seguinte comando para clonar o seu repositório forkeado:**

```bash
git clone https://github.com/<seu_nome_de_usuario>/Guavira.git
```

**Atenção:** Substitua `<seu_nome_de_usuario>` pelo seu nome de usuário real do GitHub.

**Criando uma nova branch:**

1. **Navegue até o diretório do repositório clonado na sua máquina local.**
2. **Crie uma nova branch para suas alterações:**

```bash
git checkout -b <nome_da_sua_branch>
```

**Atenção:** Substitua `<nome_da_sua_branch>` por um nome descritivo para a sua branch (ex.: "recurso-novo-recurso").

**Fazendo alterações e realizando commit:**

1. **Faça as alterações desejadas no código.**
2. **Comite suas alterações:**

```bash
git add .
git commit -m "Sua mensagem de commit"
```

**Atenção:** Substitua "Sua mensagem de commit" por uma mensagem significativa descrevendo suas alterações.

**Enviando suas alterações para o seu fork:**

1. **Envie suas alterações para a branch do seu repositório forkeado:**

```bash
git push origin <nome_da_sua_branch>
```

Agora, seu colega tem uma cópia local do repositório forkeado com sua própria branch para fazer alterações. Ele pode trabalhar na branch dele sem afetar a branch master original.

**Para mesclar suas alterações de volta ao repositório original posteriormente:**

**1. Criar uma pull request:**

* Acesse seu repositório forkeado no GitHub.
* Clique no botão "Pull request".
* Selecione a branch que contém suas alterações e a branch master do repositório original.
* Escreva uma descrição para sua pull request e envie-a.

**2. Revisão e merge:**

* O mantenedor do repositório original pode revisar sua pull request e mesclá-la na branch master se for aprovada.

Esse processo garante que seu colega possa trabalhar de forma independente em sua própria versão do código, sem afetar a branch master do repositório original. 
