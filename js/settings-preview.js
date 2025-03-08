// 初始化实时预览功能
document.addEventListener('DOMContentLoaded', function() {
  const previewContainers = document.querySelectorAll('.setting-preview');
  
  // 监听所有输入控件的变化
  document.querySelectorAll('.mdui-textfield-input, select').forEach(element => {
    element.addEventListener('input', function() {
      updateLivePreview(this);
    });
  });

  // 初始化颜色选择器
  new mdui.ColorPicker(document.querySelector('.color-picker'), {
    onChange: function(color) {
      document.querySelector('.theme-color-preview').style.backgroundColor = color;
    }
  });
});

function updateLivePreview(element) {
  const previewId = element.dataset.previewTarget;
  const previewElement = document.getElementById(previewId);
  
  switch(element.type) {
    case 'color':
      previewElement.style.backgroundColor = element.value;
      break;
    case 'range':
      previewElement.style.transform = `scale(${element.value})`;
      break;
    default:
      previewElement.innerText = element.value;
  }
}

// 显示加载状态
function showLoadingState() {
  const loader = document.createElement('div');
  loader.className = 'settings-loading';
  loader.innerHTML = `
    <div class="spinner">
      <div class="mdui-spinner"></div>
    </div>
  `;
  document.body.appendChild(loader);
}

// 表单提交处理
document.querySelector('form').addEventListener('submit', function() {
  showLoadingState();
});