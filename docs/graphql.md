запросить родительскую сущность и её дочерние сущности
```
{
  users {
    edges {
      node {
        id
        login
        avatarLink
        roles
        student {
          id
          firstName
          lastName
          middleName
          email
          phone
        }
      	manager {
          id
          firstName
          lastName
          middleName
          email
          phone
        }
        teacher {
          id
          firstName
          lastName
          middleName
          email
          phone
        }
      }
    }
  }
}
```
использовать фильтрацию
```
{
  users(login: "ivanov") {
    edges {
      node {
        id
        login
        avatarLink
        roles
        student {
          id
          firstName
          lastName
          middleName
          email
          phone
        }
      }
    }
  }
} 
```
использовать сортировку
```
{
  users(first: 3 order: { login: "ASC" }) {
    edges {
      node {
        id
        login
        avatarLink
        roles
        student {
          id
          firstName
          lastName
          middleName
          email
          phone
        }
      }
    }
  }
} 
```
мутаторы
```
mutation CreateUser($login:String!, $password:String!, $roles:Iterable! ) {
  createUser(input:{login:$login, password:$password, isActive:true, roles:$roles}) {
    user {
      id,
      login,
      roles
    }
  }
}
variables:
{
  "login": "qwerty123112456578",
  "password": "1234567890",
  "roles": ["ROLE_STUDENT"]
}

mutation UpdateUser($id:ID!, $login:String!, $password:String!, $roles:Iterable!) {
  updateUser(input:{id:$id, login:$login, password:$password, roles:$roles}) {
    user {
      login
      roles
    }
  }
}
variables:
{
  "id": "/api-platform/users/27",
  "login": "new_graphql_user",
  "password": "new_graphql_password",
  "roles": [
    "ROLE_MANAGER"
  ]
}

mutation DeleteUser($id:ID!) {
  deleteUser(input:{id:$id}) {
    user {
      id
    }
  }
}
variables:
{
    "id":"/api-platform/users/29"
}
```
