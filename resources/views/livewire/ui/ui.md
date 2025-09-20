# 📄 ListComponent - Livewire UI Component

This is a reusable `Livewire` component for displaying and filtering data lists using any Eloquent model. It supports:

- ✅ Dynamic model binding
- ✅ Local (client-side) searching
- ✅ Relationship eager loading
- ✅ Flexible column definitions
- ✅ Clean and customizable UI with Bootstrap

---

## ✅ Example Usage

```blade
<livewire:ui.list-component
    title="Users List" // string
    searchPlaceholder="Name/Email/Contact" // string
    :className="App\Models\User::class" // string*
    :filters="['company_uuid' => $company->uuid]" // array*
    :relations="['roles', 'permissions']" // array
    :columns="[
        ['field' => 'name'],
        ['field' => 'email'],
        ['field' => 'role'],
    ]" // array *
    wire:key="{{ rand() }}"
/>
