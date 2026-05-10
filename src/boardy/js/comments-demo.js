console.log('1231')
const API = 'https://api.tlop.ai-info.ru';
const PARENT_ID = 7;

async function loadItems() {
    const res = await fetch(`${API}/api/posts/${PARENT_ID}/comments`);
    const data = await res.json();
    
    document.getElementById('list').innerHTML = data.items.map(item => `
        <div>
            <strong>${esc(item.author_name)}</strong>
            <p>${esc(item.body)}</p>
        </div>
    `).join('');
}

loadItems();

document.getElementById('btn').addEventListener('click', async () => {
    const body = document.getElementById('body').value.trim();
    if (!body) return; // ← не отправляем пустой
    
    await fetch(`${API}/api/posts/${PARENT_ID}/comments`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ body: body }) // ← поля из вашей модели
    });
    
    document.getElementById('body').value = ''; // ← очистить
    loadItems(); // ← обновить список
});

function esc(str) {
    const div = document.createElement('div');
    div.textContent = str; // ← экранирует < > & "
    return div.innerHTML; // ← безопасная строка
}