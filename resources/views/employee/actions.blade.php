<div class="d-flex">
    <a href="{{ route('employees.show', ['employee' => $employee->id]) }}"class="btn btn-outline-dark btn-smme-2"><i
            class="bi-person-lines-fill"></i></a>
    <a href="{{ route('employees.edit', ['employee' => $employee->id]) }}"class="btn btn-outline-dark btn-smme-2"><i
            class="bi-pencil-square"></i></a>
    <div>
        <form action="{{ route('employees.destroy', ['employee' => $employee->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-smme2 btn-delete"
                data-name="{{ $employee->firstname . ' ' . $employee->lastname }}">
                <i class="bi-trash"></i>
                </i></button>
        </form>
    </div>
</div>
