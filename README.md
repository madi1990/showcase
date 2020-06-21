# Petstore showcase
To access this store, just host it and then visit: http://ip_address/pet.

The API work flow:

API entry(/pet/{petId}/uploadImage) -> middleware -> PetController -> DB -> ApiResponse

For the sake of simplicity, I didn't add the authentication to this demo. This can be implemented by HTTP authentication, OAuth 2 or other business related logic.