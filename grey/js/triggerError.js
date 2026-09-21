let currentStep = 1;

const form = document.querySelector('form');
const nextButton = document.getElementById('nextButton');



nextButton.addEventListener('click', (event) => {
    if (!validateCurrentStep(currentStep)) {
        event.preventDefault();
        return;
    }

    // On slide 6, allow the normal submit action.
    if (currentStep === 6) {
        return;
    }

    event.preventDefault();
    goToNextStep();
});

function isBlank(value) {
    return value.replace(/[\s\u200B-\u200D\uFEFF]/g, '') === '';
}

function isValidFirstName(value) {
    return /^[A-Za-z]{2,100}$/.test(value);
}

function isValidEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[A-Za-z]{2,}$/.test(value);
}

function validateCurrentStep(step) {
    let isStepValid = true;

    // Check first name
    if (step === 1) {
        const firstNameInput = document.getElementById('Firstname');
        const firstNameGroup = document.getElementById('FirstNameGroup');
        const firstNameError = document.getElementById('firstNameError');
        const firstNameErrorMessage = document.getElementById('firstNameErrorMessage');

        if (firstNameInput.value === '') {
            firstNameGroup.classList.add('has-error');
            firstNameError.classList.add('is-visible');
            firstNameErrorMessage.textContent = 'Enter first name';
            isStepValid = false;
        } else if (!isValidFirstName(firstNameInput.value)) {
            firstNameGroup.classList.add('has-error');
            firstNameError.classList.add('is-visible');
            firstNameErrorMessage.textContent =
                'First name must contain letters only—no spaces or symbols.';
            isStepValid = false;
        } else {
            firstNameGroup.classList.remove('has-error');
            firstNameError.classList.remove('is-visible');
        }
    }   // ✅

    // Check last name
    if (step === 1) {
        const lastNameInput = document.getElementById('Lastname');
        const lastNameGroup = document.getElementById('LastNameGroup');
        const lastNameError = document.getElementById('lastNameError');
        const lastNameErrorMessage = document.getElementById('lastNameErrorMessage');

        if (lastNameInput.value === '') {
            lastNameGroup.classList.add('has-error');
            lastNameError.classList.add('is-visible');
            lastNameErrorMessage.textContent = 'Enter last name';
            isStepValid = false;
        } else if (!isValidFirstName(lastNameInput.value)) {
            lastNameGroup.classList.add('has-error');
            lastNameError.classList.add('is-visible');
            lastNameErrorMessage.textContent =
                'Last name must contain letters only—no spaces or symbols.';
            isStepValid = false;
        } else {
            lastNameGroup.classList.remove('has-error');
            lastNameError.classList.remove('is-visible');
        }
    }   // ✅

     // Check month
    if (step === 2) {
        const month = document.getElementById('month');
        const monthGroup = document.getElementById('monthGroup');

        // Check if required element input value is blank
        if (month.value.trim() === '') {
            monthGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            monthGroup.classList.remove('has-error');
        }
    }   // ✅

    // Check day
    if (step === 2) {
        const day = document.getElementById('day');
        const dayGroup = document.getElementById('dayGroup');

        // Check if required element input value is blank
        if (day.value.trim() === '') {
            dayGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            dayGroup.classList.remove('has-error');
        }
    }

    // Check year
    if (step === 2) {
        const year = document.getElementById('year');
        const yearGroup = document.getElementById('yearGroup');

        // Check if required element input value is blank
        if (year.value.trim() === '') {
            yearGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            yearGroup.classList.remove('has-error');
        }
    }

    // Check gender
    if (step === 2) {
        const gender = document.getElementById('gender');
        const genderGroup = document.getElementById('genderGroup');

        // Check if required element input value is blank
        if (gender.value.trim() === '') {
            genderGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            genderGroup.classList.remove('has-error');
        }
    }   // ✅

    // Check email
    if (step === 3) {
        const email = document.getElementById('email');
        const emailGroup = document.getElementById('emailGroup');
        const emailError = document.getElementById('emailError');
        const emailErrorMessage = document.getElementById('emailErrorMessage');

        if (email.value === '') {
            emailGroup.classList.add('has-error');
            emailError.classList.add('is-visible');
            emailErrorMessage.textContent = 'Enter your preferred email address';
            isStepValid = false;
        } else if (!isValidEmail(email.value)) {
            emailGroup.classList.add('has-error');
            emailError.classList.add('is-visible');
            emailErrorMessage.textContent = 'Email must be in this format—email@example.com';
            isStepValid = false;
        } else {
            emailGroup.classList.remove('has-error');
            emailError.classList.remove('is-visible');
        }
    }   // ✅

    // Check phone
    if (step === 4) {
        const phone = document.getElementById('phone');
        const phoneGroup = document.getElementById('phoneGroup');

        // Check if required element input value is blank
        if (phone.value.trim() === '') {
            phoneGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            phoneGroup.classList.remove('has-error');
        }
    }

    // Check password
    if (step === 5) {
        const password = document.getElementById('password');
        const passwordGroup = document.getElementById('passwordGroup');

        // Check if required element input value is blank
        if (password.value.trim() === '') {
            passwordGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            passwordGroup.classList.remove('has-error');
        }
    }

    // Check confirmPassword
    if (step === 5) {
        const confirmPassword = document.getElementById('confirmPassword');
        const confirmPasswordGroup = document.getElementById('confirmPasswordGroup');

        // Check if required element input value is blank
        if (confirmPassword.value.trim() === '') {
            confirmPasswordGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            confirmPasswordGroup.classList.remove('has-error');
        }
    }

    // Check user_role
    if (step === 6) {
        const user_role = document.getElementById('user_role');
        const user_roleGroup = document.getElementById('user_roleGroup');

        // Check if required element input value is blank
        if (user_role.value.trim() === '') {
            user_roleGroup.classList.add('has-error');
            isStepValid = false;
        } else {
            user_roleGroup.classList.remove('has-error');
        }
    }



    // Add structural block cases for subsequent step conditions (e.g., Step 2, Step 3)
    return isStepValid;
}



function goToNextStep() {
    const currentSlide = document.querySelector(
        `.carousel-item[data-step="${currentStep}"]`
    );

    currentStep++;

    const nextSlide = document.querySelector(
        `.carousel-item[data-step="${currentStep}"]`
    );

    if (nextSlide) {
        currentSlide.classList.remove('active');
        nextSlide.classList.add('active');

        if (currentStep === 6) {
            nextButton.textContent = 'Submit';
            nextButton.type = 'submit';
        }
    }
}



// Interactive Real-time cleanups: clear error boundary highlight while the user types
document.getElementById('Firstname').addEventListener('input', function () {
    if (isValidFirstName(this.value)) {
        document.getElementById('FirstNameGroup').classList.remove('has-error');
        document.getElementById('firstNameError').classList.remove('is-visible');
    }
}); //✅

document.getElementById('Lastname').addEventListener('input', function () {
    if (isValidFirstName(this.value)) {
        document.getElementById('LastNameGroup').classList.remove('has-error');
        document.getElementById('lastNameError').classList.remove('is-visible');
    }
}); // ✅

document.getElementById('email').addEventListener('input', function () {
    if (isValidEmail(this.value)) {
        document.getElementById('emailGroup').classList.remove('has-error');
        document.getElementById('emailError').classList.remove('is-visible');
    }
}); // ✅

document.getElementById('phone').addEventListener('input', function() {
    if (this.value.trim() !== '') {
    document.getElementById('phoneGroup').classList.remove('has-error');
    }
});


document.getElementById('password').addEventListener('input', function() {
    if (this.value.trim() !== '') {
    document.getElementById('passwordGroup').classList.remove('has-error');
    }
});

document.getElementById('confirmPassword').addEventListener('input', function() {
    if (this.value.trim() !== '') {
    document.getElementById('confirmPasswordGroup').classList.remove('has-error');
    }
});

document.getElementById('err').addEventListener('div', function() {
    if (this.value.trim() !== '') {
    document.getElementById('errGroup').classList.remove('has-error');
    }
});



// ******* dashboard message *******
document.addEventListener('DOMContentLoaded', function () {

    const alerts = document.querySelectorAll(
        '#resultErrorAlert, #resultSuccessAlert'
    );

    alerts.forEach(function (alertElement) {

        setTimeout(function () {

            const alert = bootstrap.Alert.getOrCreateInstance(alertElement);

            alert.close();

        }, 5000);

    });

});

