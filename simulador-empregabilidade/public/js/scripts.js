// Quando o DOM (a página) está totalmente carregado, adiciona eventos de clique a todos os elementos com: '.user-card'
document.addEventListener('DOMContentLoaded', function () {
    const userCards = document.querySelectorAll('.user-card');
    userCards.forEach(card => {
        //Ao clicar...
        card.addEventListener('click', function () {
            const avatar = card.querySelector('img').src;
            const name = card.querySelector('h2').textContent;
            const title = card.querySelector('p').textContent;
            const cityState = card.querySelectorAll('p')[1].textContent;

            // ... Preenche o modal com informações do usuário selecionado (vindas do Back-End) e mostra o modal.
            const modalBody = document.querySelector('#userModal .modal-body');
            modalBody.innerHTML = `
                <img src="${avatar}" class="img-fluid" alt="Avatar">
                <h2>${name}</h2>
                <p><strong>Cargo:</strong> ${title}</p>
                <p><strong>Cidade e Estado:</strong> ${cityState}</p>
                <p><strong>Email:</strong> ${card.dataset.email}</p>
                <p><strong>Telefone:</strong> ${card.dataset.phone}</p>
                <p><strong>Data de Nascimento:</strong> ${card.dataset.dob}</p>
                <p><strong>Endereço:</strong> ${card.dataset.address}</p>
                <p><strong>Habilidade:</strong> ${card.dataset.keySkill}</p>
            `;

            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();

            document.getElementById('recommendButton').addEventListener('click', function() {
                // Função que utiliza EmailJS para enviar um email recomendando o usuário.
                sendRecommendationEmail({
                    name: name,
                    title: title,
                    cityState: cityState,
                    email: card.dataset.email,
                    phone: card.dataset.phone,
                    dob: card.dataset.dob,
                    address: card.dataset.address,
                    keySkill: card.dataset.keySkill,
                    avatar: avatar
                });
            });
        });
    });
});

// Função para fazer o envio dos emails (EmailJS)
function sendRecommendationEmail(user) {
    const templateParams = {
        to_email: window.env.EMAILJS_USER_EMAIL,
        subject: `Recomendação de Usuário: ${user.name}`,
        message: `
            <h1>Recomendação de Usuário</h1>
            <p><strong>Nome:</strong> ${user.name}</p>
            <p><strong>Experiência:</strong> ${user.title}</p>
            <p><strong>Habilidade:</strong> ${user.keySkill}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Telefone:</strong> ${user.phone}</p>
            <p><strong>Data de Nascimento:</strong> ${user.dob}</p>
            <p><strong>Endereço:</strong> ${user.address}</p>
        `
    };

    emailjs.send( window.env.EMAILJS_SERVICE_ID, window.env.EMAILJS_TEMPLATE_ID, templateParams)
        .then(function(response) {
            console.log('Email enviado com sucesso:', response);
            alert('Recomendação enviada com sucesso!');
        }, function(error) {
            console.error('Erro ao enviar email:', error);
            alert('Erro ao enviar recomendação.');
        });
}
