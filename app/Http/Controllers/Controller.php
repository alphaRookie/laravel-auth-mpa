<?php
//THIS FILE IS CONTROLLER BASE

namespace App\Http\Controllers; //tell laravel in what folder this file belong to

abstract class Controller
{
    // Just left it empty for now later...
}


/*
We can decide to put :

| Purpose                            | What to Add                                      | Example                                     |
| ---------------------------------- | ------------------------------------------------ | ------------------------------------------- |
| 🔁 **Reusable methods**            | Functions you use in many controllers            | `formatResponse()`, `redirectWithMessage()` |
| 🧩 **Shared traits**               | Include traits like API responses, authorization | `use HandlesAuthorization;`                 |
| 🔐 **Custom middleware logic**     | Apply a middleware to all controllers            | In `__construct()`                          |
| 🧪 **Global helper**               | Common logic like logging, formatting            | `logAction($action)`                        |
| 📦 **Base API response structure** | Standardize API JSON                             | `respond($data, $status)`                   |

*/